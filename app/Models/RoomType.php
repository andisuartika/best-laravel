<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function homestays()
    {
        return $this->belongsTo(Homestay::class, 'homestay', 'code');
    }

    public function imageRoom()
    {
        return $this->hasMany(ImageRoom::class, 'room_type', 'code');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type', 'code');
    }

    public function rates()
    {
        return $this->hasMany(RoomRate::class, 'room_type', 'code')->orderBy('price', 'asc');;
    }

    public function getMinPriceAttribute()
    {
        return $this->rates->min('price');
    }
}
