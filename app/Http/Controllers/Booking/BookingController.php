<?php

namespace App\Http\Controllers\Booking;


use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TourRate;

class BookingController extends Controller
{
    public function showPaymentPage($code)
    {
        $booking = Booking::with('details')->where('booking_code', $code)->firstOrFail();
        $transaction = Transaction::where('midtrans_order_id', $code)->latest()->first();


        $totalQty = 0;
        foreach ($booking->details as $detail) {
            $totalQty += $detail->quantity;
        }
        $items = $booking->details->map(function ($detail) {
            $item = $detail->item;
            $type = $detail->item_type;
            $rating = 0;
            $ratingCount = 0;
            $images = null;
            $ticketName = 'Unknown Ticket';
            $itemName = 'Unknown Item';

            switch ($type) {
                case 'ticket':
                    $destination = $item->destination ?? null;
                    $rating = $destination?->ratings->avg('rating') ?? 0;
                    $ratingCount = $destination?->ratings->count() ?? 0;
                    $images = $destination?->thumbnail ?? null;
                    $itemName = $destination?->name ?? $item->name ?? 'Unknown Ticket';
                    $ticketName = $item->name ?? null;
                    break;

                case 'homestay':
                    $rating = $item->homestays?->ratings->avg('rating') ?? 0;
                    $ratingCount = $item->homestays?->ratings->count() ?? 0;
                    $images = $item->imageRoom ?? null;
                    $itemName = $item->name ?? 'Unknown Homestay';
                    $itemQty = $detail->quantity;
                    break;

                case 'tour':
                    $tour = $item->tours ?? null;
                    $rating = $tour?->ratings->avg('rating') ?? 0;
                    $ratingCount = $tour?->ratings->count() ?? 0;
                    $images = $tour?->thumbnail ?? null;
                    $itemName = $tour?->name ?? 'Unknown Tour';
                    $ticketName = $item->name ?? null;
                    break;
            }

            return [
                'item_type'     => $type,
                'item_code'     => $detail->item_code,
                'item_ratings'  => [
                    'rating'        => $rating,
                    'rating_count'  => $ratingCount,
                ],
                'item_qty'      => $itemQty ?? 1,
                'total_qty'     => $totalQty ?? 1,
                'item_name'     => $itemName,
                'item_ticket' => $ticketName,
                'item_image'    => $images,
                'item_details'  => $item ?? 'No details available',
            ];
        })->toArray();


        $deadline = $booking->created_at->addMinutes(30);

        return view('booking.payment', [
            'booking'    => $booking,
            'deadline'   => $deadline,
            'totalQty'   => $totalQty,
            'items'      => $items,
            'snapToken'  => $transaction->payment_token,
            'clientKey'  => config('midtrans.client_key'),
        ]);
    }


    public function paymentSuccess($booking)
    {

        $booking = Booking::where('booking_code', $booking)->with('details')->firstOrFail();
        $items = $booking->details->map(function ($detail) {
            $item = $detail->item;

            return [
                'item_name' => $item->name ?? 'Unknown Item',
                'item_details' => $item ?? 'No details available',
            ];
        })->toArray();

        return view('booking.success', ['booking' => $booking, 'items' => $items]);
    }
}
