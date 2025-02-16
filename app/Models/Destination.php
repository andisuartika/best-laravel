<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $casts = [
    //     'category' => 'array',
    // ];

    public function category()
    {
        return $this->belongsTo(SubCategory::class, 'code', 'category');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'manager', 'id');
    }

    public function prices()
    {
        return $this->hasMany(DestinationPrice::class, 'destination_id', 'code');
    }

    public function images()
    {
        return $this->hasMany(DestinationImage::class, 'destination', 'code');
    }


    public function categories()
    {
        return $this->belongsToMany(SubCategory::class, 'category_destination', 'destination', 'category', 'code', 'code');
    }
}
