<?php

namespace App\Http\Controllers\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use App\Mail\VoucherEmail;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmed;
use App\Services\VoucherSender;
use App\Services\WalletService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\TicketGenerator;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendBookingMailController extends Controller
{
    public function sendEmail(Request $request, WalletService $walletService)
    {
        $booking_code = 'FGBLNU9I';

        $booking = Booking::with('details', 'user')->where('booking_code', $booking_code)->first();
        $transaction = Transaction::where('midtrans_order_id', $booking_code)->latest()->first();

        DB::transaction(function () use ($booking, $transaction, $walletService) {
            $booking->update([
                'payment_status' => 'settlement',
                'booking_status' => 'paid',
            ]);
            $transaction->update(['payment_status' => 'settlement']);

            TicketGenerator::generate($booking);
            VoucherSender::send($booking, $transaction);

            $manager = $booking->user;
            $walletService->processBooking(
                $manager,
                $transaction->amount,
                'booking',
                $booking->id
            );
        });

        dd('wallet service');

        // VoucherSender::send($booking, $transaction);

        // return ('email send');

        //cek jenis item yang dipesan
        $detail = $booking->details->first();

        //jika homestay
        if ($detail->item_type == 'homestay') {
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
            return view('emails.accomodation', $data);
        } else if ($detail->item_type == 'ticket') {
            $booking = Booking::with('details.ticketDetails', 'details.ticket')->where('booking_code', $booking_code)->first();
            $item = $detail->item;

            $tickets = collect();
            foreach ($booking->details as $detail) {
                if ($detail->item_type === 'ticket') {
                    $destinationPrice = $detail->item; // via getItemAttribute()

                    foreach ($detail->ticketDetails as $ticket) {
                        $result = Builder::create()
                            ->data($ticket->ticket_code)
                            ->size(200)
                            ->margin(10)
                            ->build();

                        $qrPng = $result->getString(); // binary PNG string
                        $qrBase64 = base64_encode($qrPng);

                        $tickets->push([
                            'ticket_code'  => $ticket->ticket_code,
                            'qrcode'  => $qrBase64,
                            'ticket_name'  => $destinationPrice->name ?? '-',
                            'ticket_price' => $destinationPrice->price ?? 0,
                            'is_used'      => $ticket->is_used,
                            'used_at'      => $ticket->used_at,
                        ]);
                    }
                }
            }


            //item details
            $total =    0;
            $item_details = collect();
            foreach ($booking->details as $detail) {
                if ($detail->item_type === 'ticket') {
                    $destinationPrice = $detail->item;
                    $total += $detail->subtotal;
                    $item_details->push([
                        'ticket_name'  => $destinationPrice->name ?? '-',
                        'quantity' => $detail->quantity ?? 0,
                        'price' => $detail->price ?? 0,
                        'sub_total' => $detail->subtotal,
                    ]);
                }
            }

            $checkin = \Carbon\Carbon::parse($detail->check_in_date);
            $date = \Carbon\Carbon::parse($booking->booking_date);

            //mengambil nilai fee / tax
            $tax = $booking->total_amount - $total;
            $data = [
                'booking_code' => $booking->booking_code,
                'date' => $date->format('l, d M Y'),
                'guest_name' => Str::upper($booking->name),
                'email' => $booking->email,
                'status' => $booking->booking_status,
                'destination_name' => $item->destination->name,
                'image' => config('app.url') . '/' . $item->destination->thumbnail,
                'room_type' => $item->name,
                'address' => $item->destination->address,
                'map_link' => "https://www.google.com/maps?q={$item->destination->latitude},{$item->destination->longitude}",
                'manager' => [
                    'phone' => $item->destination->user->phone,
                    'email' => $item->destination->user->email,
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


            return view('emails.ticket', $data);
        } else if ($detail->item_type == 'tour') {
            $booking = Booking::with('details.ticketDetails', 'details.ticket')->where('booking_code', $booking_code)->first();
            $item = $detail->item;

            $tickets = collect();
            foreach ($booking->details as $detail) {
                if ($detail->item_type === 'tour') {
                    $tourPrice = $detail->item; // via getItemAttribute()

                    foreach ($detail->ticketDetails as $ticket) {
                        $result = Builder::create()
                            ->data($ticket->ticket_code)
                            ->size(200)
                            ->margin(10)
                            ->build();

                        $qrPng = $result->getString(); // binary PNG string
                        $qrBase64 = base64_encode($qrPng);

                        $tickets->push([
                            'ticket_code'  => $ticket->ticket_code,
                            'qrcode'  => $qrBase64,
                            'ticket_name'  => $tourPrice->name ?? '-',
                            'ticket_price' => $tourPrice->price ?? 0,
                            'is_used'      => $ticket->is_used,
                            'used_at'      => $ticket->used_at,
                        ]);
                    }
                }
            }


            //item details
            $total =    0;
            $item_details = collect();
            foreach ($booking->details as $detail) {
                if ($detail->item_type === 'tour') {
                    $tourPrice = $detail->item;
                    $total += $detail->subtotal;
                    $item_details->push([
                        'ticket_name'  => $tourPrice->name ?? '-',
                        'quantity' => $detail->quantity ?? 0,
                        'price' => $detail->price ?? 0,
                        'sub_total' => $detail->subtotal,
                    ]);
                }
            }

            $checkin = \Carbon\Carbon::parse($detail->check_in_date);
            $date = \Carbon\Carbon::parse($booking->booking_date);

            //mengambil nilai fee / tax
            $tax = $booking->total_amount - $total;
            $data = [
                'booking_code' => $booking->booking_code,
                'date' => $date->format('l, d M Y'),
                'guest_name' => Str::upper($booking->name),
                'email' => $booking->email,
                'status' => $booking->booking_status,
                'name' => $item->tours->name,
                'image' => config('app.url') . '/' . $item->tours->thumbnail,
                'room_type' => $item->name,
                'manager' => [
                    'phone' => $item->tours->user->phone,
                    'email' => $item->tours->user->email,
                ],
                'address' => $item->destination->address ?? null,
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


            return view('emails.pdf.ticket', $data);
        }
    }
}
