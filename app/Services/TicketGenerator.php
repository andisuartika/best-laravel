<?php

namespace App\Services;

use App\Model\Booking;
use App\Models\BookingDetail;
use App\Models\TicketDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TicketGenerator
{
    public static function generate($booking)
    {
        Log::info("🎫  Generating Ticket(s) ");
        $details = $booking->details()->whereIn('item_type', ['ticket', 'tour'])->get();

        foreach ($details as $detail) {
            for ($i = 0; $i < $detail->quantity; $i++) {
                do {
                    $code = strtoupper(Str::random(12));
                } while (TicketDetail::where('ticket_code', $code)->exists());

                TicketDetail::create([
                    'booking_detail_id' => $detail->id,
                    'ticket_code' => $code,
                ]);
            }

            Log::info('🎫 Ticket(s) generated for detail ID: ' . $detail->id);
        }

        Log::info('✅ All ticket details created for booking ID: ' . $booking->id);
    }
}
