<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay', 'code');
    }
    public function type()
    {
        return $this->belongsTo(RoomType::class, 'room_type', 'code');
    }
}
