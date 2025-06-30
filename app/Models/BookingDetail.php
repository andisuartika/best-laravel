<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingDetail extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $appends = ['item'];

    // Relasi ke booking utama
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking');
    }

    public function getItemAttribute()
    {
        return match ($this->item_type) {
            'ticket' => DestinationPrice::with('destination.images', 'destination.ratings', 'destination.prices')->where('code', $this->item_code)->first(),
            'homestay' => RoomType::with([
                'imageRoom',
                'homestays.ratings',
                'homestays.user'
            ])
                ->where('code', $this->item_code)
                ->first(),
            'tour' => TourRate::with('tours')->where('code', $this->item_code)
                ->first(),
            default => null,
        };
    }

    public function ticket()
    {
        return $this->belongsTo(DestinationPrice::class, 'item_code', 'code');
    }

    public function ticketDetail()
    {
        return $this->hasOne(TicketDetail::class, 'booking_detail_id', 'id');
    }

    public function ticketDetails()
    {
        return $this->hasMany(TicketDetail::class, 'booking_detail_id', 'id');
    }
}
