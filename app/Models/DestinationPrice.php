<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationPrice extends Model
{
    use HasFactory;

    //tabel name
    protected $table = 'destination_prices';

    protected $fillable = [
        'village_id',
        'destination_id',
        'code',
        'name',
        'description',
        'valid_from',
        'valid_to',
        'price',
    ];

    //relation to destination
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'code');
    }
}
