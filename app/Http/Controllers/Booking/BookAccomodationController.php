<?php

namespace App\Http\Controllers\Booking;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Booking;
use App\Models\Homestay;
use App\Models\RoomType;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BookAccomodationController extends Controller
{
    protected MidtransService $midtrans;
    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }


    public function homestay(Request $request)
    {
        // 1. Load country codes
        $json = File::get(resource_path('data/country_codes.json'));
        $countries = json_decode($json, true);

        $today = Carbon::today();

        // 2. Decode items payload from query string
        // Expecting items=[{"roomType":"001","quantity":2},...]
        $itemsParam = $request->query('items', '[]');
        $itemsData = json_decode($itemsParam, true);
        if (!is_array($itemsData)) {
            abort(400, 'Invalid items payload');
        }

        // 3. Collect all roomType codes
        $codes = array_column($itemsData, 'roomType');

        // 4. Fetch RoomType models with latest valid rate and image
        $roomTypes = RoomType::whereIn('code', $codes)
            ->with([
                'imageRoom',
                'rates' => function ($q) use ($today) {
                    $q->whereDate('valid_from', '<=', $today)
                        ->whereDate('valid_to', '>=', $today)
                        ->orderByDesc('valid_from')
                        ->limit(1);
                }
            ])
            ->get();

        if ($roomTypes->isEmpty()) {
            abort(404, 'Room types not found');
        }


        // 5. Fetch homestay (assuming same homestay code)
        $homestayCode = $roomTypes->first()->homestay;
        $homestay = Homestay::where('code', $homestayCode)
            ->withCount('ratings')
            ->with('ratings')
            ->firstOrFail();


        // 6. Calculate nights, guests
        $checkIn   = Carbon::parse($request->query('checkIn'));
        $checkOut  = Carbon::parse($request->query('checkOut'));
        $nights    = $checkIn->diffInDays($checkOut);
        $guests    = (int) $request->query('guest', 1);

        // 7. Build items detail and compute subtotal
        $subtotal = 0;
        $items    = [];
        $galleries = [];
        $totalRoom = 0;

        foreach ($roomTypes as $rt) {
            $rate = optional($rt->rates->first())->price ?? 0;
            // find quantity from payload
            $match = collect($itemsData)->firstWhere('roomType', $rt->code);
            $qty   = $match['quantity'] ?? 1;


            $totalPerType = $rate * $nights * $qty;
            $subtotal += $totalPerType;

            $items[] = [
                'code'      => $rt->code,
                'name'      => $rt->name,
                'quantity'  => $qty,
                'rate'      => $rate,
                'nights'    => $nights,
                'total'     => $totalPerType,
            ];

            $galleries[] = [
                'url' => $rt->thumbnail,
            ];

            // add image galleries
            foreach ($rt->imageRoom as $image) {
                $galleries[] = [
                    'url' => $image->url,
                ];
            }
        }

        foreach ($items as $item) {
            $totalRoom += $item['quantity'];
        }

        // 8. Tax and grand total
        $tax        = $subtotal * 0.15;
        $grandTotal = $subtotal + $tax;

        // 9. Prepare data for view
        $data = [
            'homestay'    => $homestay,
            'galleries'   => $galleries,
            'items'       => $items,
            'subtotal'    => $subtotal,
            'tax'         => $tax,
            'totalPrice'  => $grandTotal,
            'checkIn'     => $checkIn->toDateString(),
            'checkOut'    => $checkOut->toDateString(),
            'totalRoom'   => $totalRoom,
            'nights'      => $nights,
            'guests'      => $guests,
        ];


        return view('booking.homestay-booking', compact('data', 'countries'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'data'  => 'required|json',
            'notes' => 'nullable|string',
        ]);
        $data = json_decode($request->input('data'), true);

        // Ambil dan gabungkan, buang 0 di depan nomor
        $countryCode = $request->input('phone_country');  // misal: +62
        $phone = ltrim($request->input('phone'), '0'); // hilangkan leading zero

        $fullPhone = $countryCode . $phone; // misal: +628123456789


        DB::beginTransaction();
        try {
            // 1. Simpan booking
            $booking = Booking::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $fullPhone,
                'booking_date'   => now(),
                'total_amount'   => (int) ceil($data['totalPrice']),
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'booking_code'   => strtoupper(Str::random(8)),
                'special_req'    => $request->notes,
                'guest_count'    => $data['guests'],
                'manager'        => $data['homestay']['manager'], // ambil manager dari homestay
            ]);

            // 2. Simpan detail booking (accommodation)
            foreach ($data['items'] as $item) {
                BookingDetail::create([
                    'booking'        => $booking->id,
                    'item_type'      => 'homestay',
                    'item_code'      => $item['code'],
                    'quantity'       => $item['quantity'],
                    'price'          => $item['rate'],
                    'check_in_date'  => Carbon::parse($data['checkIn'])->format('Y-m-d'),
                    'check_out_date' => Carbon::parse($data['checkOut'])->format('Y-m-d'),
                    'subtotal'       => (int) ceil($item['total']),
                    'discount'       => 0,
                ]);
            }

            // 3. Midtrans Configuration & Snap Token
            MidtransService::config();

            $snapParams = [
                'transaction_details' => [
                    'order_id'     => $booking->booking_code,
                    'gross_amount' => $booking->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $booking->name,
                    'email'      => $booking->email,
                    'phone'      => $booking->phone,
                ],
                'enabled_payments' => ['gopay', 'bank_transfer', 'qris'],
            ];

            $snapToken = $this->midtrans->getSnapToken($snapParams);

            // 4. Simpan Transaksi
            Transaction::create([
                'booking'           => $booking->id,
                'amount'            => $booking->total_amount,
                'transaction_date'  => now(),
                'payment_method'   => 'midtrans',
                'payment_status'    => 'pending',
                'transaction_code'  => 'TRX-' . strtoupper(Str::random(8)),
                'midtrans_order_id' => $booking->booking_code,
                'payment_token'     => $snapToken,
            ]);

            DB::commit();

            // Redirect ke halaman pembayaran
            return redirect()->route('booking.payment', $booking->booking_code);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan booking: ' . $e->getMessage(),
            ], 500);
        }
    }
}
