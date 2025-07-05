<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    // Relasi ke booking
    public function book()
    {
        return $this->belongsTo(Booking::class, 'booking');
    }
}
