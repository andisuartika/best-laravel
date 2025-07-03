<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['details'])
            ->where('manager', Auth::user()->id)
            ->orderBy('created_at', 'desc') // atau 'asc' jika ingin lama ke baru
            ->get();


        $formatted = $bookings->map(function ($booking) {
            // Ambil tipe pertama dari booking details
            $type = optional($booking->details->first())->item_type;

            return [
                'id' => $booking->id,
                'invoice' => $booking->booking_code,
                'name' => $booking->name,
                'email' => $booking->email,
                'date' => \Carbon\Carbon::parse($booking->booking_date)->format('d M Y'),
                'amount' => currency($booking->total_amount),
                'status' => ucfirst($booking->payment_status),
                'type' => $type, // ← Tambahkan ini
                'action' => $booking->booking_code,
            ];
        });


        return view('admin.booking.index', [
            'bookings' => $formatted,
        ]);
    }

    public function invoice($code)
    {
        $booking = Booking::with('details.ticketDetails', 'details.ticket')
            ->where('booking_code', $code)->first();
        $item_type = $booking->details->first()->item_type;

        $formatted = $booking->details->map(function ($detail, $index) {
            return [
                'no' => $index + 1,
                'id' => $detail->id,
                'title' => $detail->item->name ?? '-',
                'quantity' => $detail->quantity,
                'price' => currency($detail->price),
                'amount' => currency($detail->subtotal),
            ];
        });

        $total = collect($formatted)->sum(function ($item) {
            return (int) str_replace(['Rp', '.', ' '], '', $item['amount']);
        });




        $checkin = \Carbon\Carbon::parse($booking->check_in_date);
        $checkout = \Carbon\Carbon::parse($booking->check_out_date);
        $tax = $booking->total_amount - $total;

        $data = [
            'address' => Auth::user()->address,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
            'item_details' => $formatted,
            'sub_total' => currency($total),
            'tax' => currency($tax),
            'checkin' => $checkin,
            'checkout' => $checkout,
            'item_type' => $item_type,
        ];


        return view('admin.booking.invoice', ['booking' => $booking, 'data' => $data]);
    }
}
