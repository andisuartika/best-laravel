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
            'ticket' => DestinationPrice::with('destination.images', 'destination.ratings')->where('code', $this->item_code)->first(),
            'homestay' => RoomType::with([
                'imageRoom',
                'homestays.ratings','homestays.user'
            ])
                ->where('code', $this->item_code)
                ->first(),
            'tour' => TourRate::where('code', $this->item_code)
                ->first(),
            default => null,
        };
    }
}
