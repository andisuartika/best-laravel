<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\VoucherEmail;

class VoucherSender
{
    public static function send($booking, $transaction)
    {
        $detail = $booking->details->first();
        $item = $detail->item;
        $checkin = \Carbon\Carbon::parse($detail->check_in_date);
        $checkout = \Carbon\Carbon::parse($detail->check_out_date);

        $data = [
            'booking_code' => $booking->booking_code,
            'item_code' => $item->code,
            'item_name' => $item->name,
            'date' => $booking->booking_date,
            'guest_name' => $booking->name,
            'email' => $booking->email,
            'status' => $booking->status,
            'hotel_name' => $item->homestays->name,
            'image' => config('app.url') . '/' . $item->thumbnail,
            'room_type' => $item->name,
            'address' => $item->homestays->address,
            'map_link' => "https://www.google.com/maps?q={$item->homestays->latitude},{$item->homestays->longitude}",
            'manager' => [
                'phone' => $item->homestays->user->phone,
                'email' => $item->homestays->user->email,
            ],
            'checkin' => $checkin->format('l, d M Y'),
            'checkout' => $checkout->format('l, d M Y'),
            'diffInNight' => $checkin->diffInDays($checkout),
            'promotion' => '-',
            'rooms' => $detail->quantity,
            'extra_bed' => '-',
            'adults' => $booking->guest_count,
            'capacity' => $item->capacity,
            'breakfast' => 'Yes, Included',
            'inclusions' => '-',
            'promo_benefits' => implode(', ', json_decode($item->facilities)),
            'payment_type' => $transaction->payment_method,
            'note' => $booking->note ?? '-',
        ];

        $pdf = Pdf::loadView('emails.pdf.voucher', $data);
        Mail::to($booking->email)->send(new VoucherEmail($pdf->output(), $data));
    }
}
