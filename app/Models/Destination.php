<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(SubCategory::class, 'code', 'category');
    }
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager', 'code');
    }
}
