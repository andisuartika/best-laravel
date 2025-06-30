<?php

namespace App\Services;

use App\Mail\TicketEmail;
use App\Models\Booking;
use App\Mail\VoucherEmail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Mail;

class VoucherSender
{

    public static function send($booking, $transaction)
    {
        $detail = $booking->details->first();
        $type = $detail->item_type;

        match ($type) {
            'homestay' => self::sendHomestayVoucher($booking, $transaction),
            'ticket'   => self::sendTicketOrTour($booking, $transaction, 'ticket'),
            'tour'     => self::sendTicketOrTour($booking, $transaction, 'tour'),
            default    => throw new \Exception("Unsupported item type: $type"),
        };
    }

    protected static function sendHomestayVoucher($booking, $transaction)
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

    protected static function sendTicketOrTour($booking, $transaction, $type)
    {
        $booking = Booking::with('details.ticketDetails', 'details.ticket')->where('booking_code', $booking->booking_code)->first();
        $detail = $booking->details->firstWhere('item_type', $type);
        $item = $detail->item;

        $tickets = collect();
        $item_details = collect();
        $total = 0;

        foreach ($booking->details->where('item_type', $type) as $detail) {
            $priceItem = $detail->item;
            $total += $detail->subtotal;

            // QR Code
            foreach ($detail->ticketDetails as $ticket) {
                $qrBase64 = base64_encode(
                    Builder::create()
                        ->data($ticket->ticket_code)
                        ->size(200)
                        ->margin(10)
                        ->build()
                        ->getString()
                );

                $tickets->push([
                    'ticket_code' => $ticket->ticket_code,
                    'qrcode' => $qrBase64,
                    'ticket_name' => $priceItem->name ?? '-',
                    'ticket_price' => $priceItem->price ?? 0,
                    'is_used' => $ticket->is_used,
                    'used_at' => $ticket->used_at,
                ]);
            }

            $item_details->push([
                'ticket_name' => $priceItem->name ?? '-',
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'sub_total' => $detail->subtotal,
            ]);
        }

        $checkin = \Carbon\Carbon::parse($detail->check_in_date);
        $date = \Carbon\Carbon::parse($booking->booking_date);
        $tax = $booking->total_amount - $total;

        $location = $type === 'ticket' ? $item->destination : $item->tours;

        $data = [
            'booking_code' => $booking->booking_code,
            'date' => $date->format('l, d M Y'),
            'guest_name' => Str::upper($booking->name),
            'email' => $booking->email,
            'status' => $booking->booking_status,
            'name' => $location->name,
            'image' => config('app.url') . '/' . $location->thumbnail,
            'room_type' => $item->name,
            'address' => $location->address ?? '-',
            'map_link' => "https://www.google.com/maps?q={$location->latitude},{$location->longitude}",
            'manager' => [
                'phone' => $location->user->phone,
                'email' => $location->user->email,
            ],
            'item_details' => $item_details,
            'ticket_details' => $tickets,
            'checkin' => $checkin->format('l, d M Y'),
            'promotion' => '-',
            'ticket_count' => $booking->guest_count,
            'payment_type' => $transaction->payment_method,
            'total' => $total,
            'tax' => $tax,
            'total_amount' => $booking->total_amount,
            'note' => $booking->note ?? '-',
        ];

        $pdf = Pdf::loadView('emails.pdf.ticket', $data);
        Mail::to($booking->email)->send(new TicketEmail($pdf->output(), $data));
    }
}
