<?php

namespace App\Http\Controllers\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use App\Mail\VoucherEmail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmed;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SendBookingMailController extends Controller
{
    public function VoucherHomestayBooking(Request $request)
    {
        $booking_code = '575XGOB4';

        $booking = Booking::with('details')->where('booking_code', $booking_code)->first();
        $transaction = Transaction::where('midtrans_order_id', $booking_code)->latest()->first();


        $items = $booking->details->map(function ($detail) {
            $item = $detail->item;
            //image
            $rootUrl = config('app.url');
            $img =  $rootUrl . '/' . $item->thumbnail;

            //maps
            $latitude = $item->homestays->latitude;
            $longitude = $item->homestays->longitude;
            $map_link = "https://www.google.com/maps?q={$latitude},{$longitude}";

            //get manager info
            $manager_phone = $item->homestays->user->phone;
            $manager_email = $item->homestays->user->email;


            return ['item_name' => $item->name, 'item_code' => $item->code, 'homestays' => $item->homestays->name, 'homestays_adress' => $item->homestays->address, 'facilities' => json_decode($item->facilities), 'image' => $img, 'map_link' => $map_link, 'manager' => ['phone' => $manager_phone, 'email' => $manager_email], 'capcity' => $item->capacity];
        });
        $item = $items[0];
        $booking_detail = $booking->details->first();
        $checkin = Carbon::parse($booking_detail->check_in_date);
        $checkout = Carbon::parse($booking_detail->check_out_date);
        $check_in_date = $checkin->format('l, d M Y');
        $check_out_date = $checkout->format('l, d M Y');

        $diffInNight = $checkin->diffInDays($checkout);


        $data = [
            'booking_code' => $booking->booking_code,
            'item_code' => $item['item_code'],
            'item_name' => $item['item_name'],
            'date' => $booking->booking_date,
            'guest_name' => $booking->name,
            'email' =>  $booking->email,
            'status' => $booking->status,
            'hotel_name' => $item['homestays'],
            'image' => $item['image'],
            'room_type' => $item['item_name'],
            'address' => $item['homestays_adress'],
            'map_link' => $item['map_link'],
            'manager' => $item['manager'],
            'checkin' => $check_in_date,
            'checkout' => $check_out_date,
            'diffInNight' => $diffInNight,
            'promotion' => '-',
            'rooms' => $booking_detail->quantity,
            'extra_bed' => '-',
            'adults' => $booking->guest_count,
            'capacity' => $item['capcity'],
            'breakfast' => 'Yes, Included',
            'inclusions' => '-',
            'promo_benefits' => implode(', ', $item['facilities']),
            'payment_type' => $transaction->payment_method,
            'note' => $booking->note ?? '-',
        ];


        $pdf = Pdf::loadView('emails.pdf.voucher', $data);

        // Kirim sebagai lampiran ke Mailable
        Mail::to('pt.andisuartika@gmail.com')->send(new VoucherEmail($pdf->output(), $data));
    }
}
