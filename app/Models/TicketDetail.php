<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bookingDetail()
    {
        return $this->belongsTo(BookingDetail::class);
    }
    
}
