<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    // Relasi ke detail booking
    public function details()
    {
        return $this->hasMany(BookingDetail::class, 'booking');
    }

    // Relasi ke transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking');
    }

    // Jika hanya 1 transaksi (opsional)
    public function latestTransaction()
    {
        return $this->hasOne(Transaction::class, 'booking')->latestOfMany();
    }
}
