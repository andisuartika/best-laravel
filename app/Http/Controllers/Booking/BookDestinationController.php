<?php

namespace App\Http\Controllers\Booking;

use Midtrans\Snap;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use App\Models\DestinationPrice;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BookDestinationController extends Controller
{
    protected MidtransService $midtrans;
    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }
    public function destination(Request $request)
    {
        $json = File::get(resource_path('data/country_codes.json'));
        $countries = json_decode($json, true);
        $prefillData = [];


        $ticketTypes = $request->input('ticket_type');
        $quantities = $request->input('quantity');

        if (count($ticketTypes) !== count($quantities)) {
            return response()->json(['error' => 'Invalid ticket data.'], 422);
        }

        $tickets = DestinationPrice::whereIn('code', $ticketTypes)->get();


        $total = 0;
        $pax = 0;
        $details = [];

        foreach ($ticketTypes as $index => $code) {
            $ticket = $tickets->firstWhere('code', $code);
            $qty = (int) $quantities[$index];

            if ($ticket && $qty > 0) {
                $subtotal = $ticket->price * $qty;
                $details[] = [
                    'code' => $ticket->code,
                    'name' => $ticket->name,
                    'price' => $ticket->price,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
                $pax += $qty;
            }
        }

        // Tax 15%
        $tax = $total * 0.15;

        $prefillData = [
            'slug' => $request->query('slug'),
            'ticket' => $details,
            'ticket_date' => $request->query('date'),
            'total' => $total,
            "tax" => $tax,
            "pax" => $pax,
            "total_price" => $total + $tax,
        ];



        $destination = Destination::where('slug', $request->query('slug'))->withCount('ratings')->with('images', 'ratings')->first();
        return view("booking.destination-booking", compact("countries", "prefillData", "destination"));
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


        if (!$data || !isset($data['ticket']) || !is_array($data['ticket'])) {
            return response()->json(['error' => 'Invalid booking data.'], 422);
        }

        // Ambil dan gabungkan, buang 0 di depan nomor
        $countryCode = $request->input('phone_country');  // misal: +62
        $phone = ltrim($request->input('phone'), '0'); // hilangkan leading zero

        $fullPhone = $countryCode . $phone; // misal: +628123456789

        //Get Destination
        $destination = Destination::where('slug', $data['slug'])->first();

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
                'guest_count'    => $data['pax'],
                'manager'        => $destination->manager,
            ]);

            // 2. Simpan ticket sebagai detail
            foreach ($data['ticket'] as $ticket) {
                BookingDetail::create([
                    'booking'        => $booking->id,
                    'item_type'      => 'ticket',
                    'item_code'      => $ticket['code'],
                    'quantity'       => $ticket['quantity'],
                    'price'          => $ticket['price'],
                    'check_in_date'  => $data['ticket_date'],
                    'subtotal'       => (int) ceil($ticket['subtotal']),
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
