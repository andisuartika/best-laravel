<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour',
        'name',
        'description',
        'price',
        'valid_from',
        'valid_to',
    ];
}
