<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'bank_id',
        'amount',
        'status',
        'request_date',
        'approval_date',
        'payment_date',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(TransactionWd::class, 'withdrawal_id');
    }

    protected $casts = [
        'amount' => 'float',
        'request_date' => 'datetime',
        'approval_date' => 'datetime',
        'payment_date' => 'datetime',
    ];
}
