<?php

namespace App\Http\Controllers\Booking;


use Carbon\Carbon;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\Homestay;
use App\Models\RoomType;
use App\Models\TourRate;
use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DestinationPrice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class BookingController extends Controller
{
    public function showPaymentPage($code)
    {
        $booking = Booking::where('booking_code', $code)->firstOrFail();
        $transaction = Transaction::where('midtrans_order_id', $code)->latest()->first();

        return view('booking.payment', [
            'booking'    => $booking,
            'snapToken'  => $transaction->payment_token,
            'clientKey'  => config('midtrans.client_key'),
        ]);
    }
}
