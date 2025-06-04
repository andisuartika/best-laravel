<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
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


    public function destination()
    {
        return $this->belongsTo(Destination::class, 'code', 'destination');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'manager', 'id');
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'tour_destinations', 'tour', 'destination', 'code', 'code');
    }

    public function ratings(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Rating::class, 'rateable');
    }
}
