<?php

namespace App\Models;

use App\Models\Manager;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homestay extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


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

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'homestay_facilities', 'homestay_code', 'facility_id', 'code', 'id');
    }

    public function ratings(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Rating::class, 'rateable');
    }
}
