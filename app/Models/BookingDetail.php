<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingDetail extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    // Relasi ke booking utama
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking');
    }

    // Jika ingin ambil info item (polymorphic lookup manual)
    public function item()
    {
        // Custom logic bisa dibuat di controller/service
        return match ($this->item_type) {
            'ticket' => DestinationPrice::where('code', $this->item_code)->first(),
            'homestay' => Homestay::where('code', $this->item_code)->first(),
            'tour' => Tour::where('code', $this->item_code)->first(),
            default => null,
        };
    }
}
