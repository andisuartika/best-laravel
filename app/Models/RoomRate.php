<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomRate extends Model
{
    use HasFactory;
    protected $table = "room_rates";
    protected $fillable = [
        'room_type',
        'name',
        'price',
        'extra_bed_price',
        'valid_from',
        'valid_to',
    ];
}
