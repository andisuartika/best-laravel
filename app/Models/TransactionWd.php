<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionWd extends Model
{
    protected $table = 'transaction_wds';
    protected $fillable = [
        'withdrawal_id',
        'amount',
        'status',
        'payment_method',
        'payment_ref',
    ];

    public function withdrawal(): BelongsTo
    {
        return $this->belongsTo(Withdrawal::class);
    }

    protected $casts = [
        'amount' => 'float',
    ];
}
