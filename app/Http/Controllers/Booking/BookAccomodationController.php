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
        $json = File::get(resource_path('data/country_codes.json'));
        $countries = json_decode($json, true);

        $today = Carbon::today();

        $roomtypes = RoomType::where('code', $request->query('code'))->with(['imageRoom',  'rates' => function ($query) use ($today) {
            $query->whereDate('valid_from', '<=', $today)
                ->whereDate('valid_to', '>=', $today)
                ->orderByDesc('valid_from') // ambil yang terbaru
                ->limit(1); // hanya 1 harga aktif
        }])
            ->first();


        $homestay = Homestay::where('code', $roomtypes->homestay)->withCount('ratings')->with('ratings')->first();

        $bookingType = $request->query('type');
        $prefillData = [];

        $checkin = Carbon::parse($request->query('checkIn'));
        $checkout = Carbon::parse($request->query('checkOut'));

        $diffInNights = $checkin->diffInDays($checkout);
        $quantity = (int) $request->query('quantity', 1); // Default quantity to 1 if not provided
        $roomPrice = $roomtypes->rates[0]->price ?? 0;
        $total = $roomtypes->rates[0]->price * $diffInNights * $quantity; // Total price calculation
        $tax = $total * 0.15; // Tax 15%

        $prefillData = [
            'code' => $request->query('code'),
            'quantity' => $quantity,
            'guests' => $request->query('guest'),
            'checkIn' => $checkin,
            'checkOut' => $checkout,
            'diffInNight' => $diffInNights,
            'roomPrice' => $roomPrice,
            'total' => $total,
            'tax' => $tax,
            'total_price' => $total + $tax,
        ];



        return view("booking.homestay-booking", compact("countries", "prefillData", "homestay", "roomtypes"));
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

        //Get Homestay by code
        $roomtypes = RoomType::where('code', $data['code'])->first();
        $homestay = Homestay::where('code', $roomtypes->homestay)->first();
        if (!$homestay) {
            return response()->json(['error' => 'Homestay not found.'], 404);
        }


        DB::beginTransaction();
        try {
            // 1. Simpan booking
            $booking = Booking::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $fullPhone,
                'booking_date'   => now(),
                'total_amount'   => (int) ceil($data['total_price']),
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'booking_code'   => strtoupper(Str::random(8)),
                'special_req'    => $request->notes,
                'guest_count'    => $data['quantity'], // jumlah kamar = jumlah tamu
                'manager'        => $homestay->manager, // ambil manager dari homestay
            ]);

            // 2. Simpan detail booking (accommodation)
            BookingDetail::create([
                'booking'        => $booking->id,
                'item_type'      => 'homestay',
                'item_code'      => $data['code'],
                'quantity'       => $data['quantity'],
                'price'          => $data['roomPrice'],
                'check_in_date'  => Carbon::parse($data['checkIn'])->format('Y-m-d'),
                'check_out_date' => Carbon::parse($data['checkOut'])->format('Y-m-d'),
                'subtotal'       => (int) ceil($data['total']),
                'discount'       => 0,
            ]);

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
