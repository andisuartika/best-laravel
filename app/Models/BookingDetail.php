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
            'ticket' => DestinationPrice::where('code', $this->item_code)->first(),
            'homestay' => RoomType::with([
                'imageRoom',
                'homestays.ratings', // ini akan eager load
            ])
                ->where('code', $this->item_code)
                ->first(),

            'tour' => Tour::where('code', $this->item_code)->first(),
            default => null,
        };
    }
}
