<?php

namespace App\Models;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homestay extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'manager', 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'code');
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class, 'homestay', 'code');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'code', 'homestay');
    }
}
