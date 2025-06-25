<?php

namespace App\Http\Controllers\Booking;


use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BookingController extends Controller
{
    public function showPaymentPage($code)
    {
        $booking = Booking::with('details')->where('booking_code', $code)->firstOrFail();
        $transaction = Transaction::where('midtrans_order_id', $code)->latest()->first();


        $items = $booking->details->map(function ($detail) {
            $item = $detail->item;

            $rating = $item->homestays->ratings->avg('rating') ?? 0;
            $ratingCount = $item->homestays->ratings->count() ?? 0;


            return [
                'item_type' => $item->item_type,
                'item_code' => $detail->item_code,
                'item_ratings' => [
                    'rating' => $rating,
                    "rating_count" => $ratingCount,
                ],
                'item_name' => $item->name ?? 'Unknown Item',
                'item_image' => $item->imageRoom ?? null,
                'item_details' => $item ?? 'No details available',
            ];
        })->toArray();

        $deadline = Carbon::parse($booking->created_at)->addMinutes(30);

        return view('booking.payment', [
            'booking'    => $booking,
            'deadline'   => $deadline,
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
