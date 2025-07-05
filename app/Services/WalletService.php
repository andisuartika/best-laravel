<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    protected float $feePercent = 15; // bisa disesuaikan atau dikonfigurasi

    public function processBooking(User $manager, float $totalAmount, string $referenceType, int $referenceId): void
    {
        $fee = round($totalAmount * ($this->feePercent / 100), 2);
        $managerAmount = $totalAmount - $fee;

        DB::transaction(function () use ($manager, $fee, $managerAmount, $referenceType, $referenceId) {
            // 1. Wallet Manager
            $managerWallet = Wallet::firstOrCreate(['user_id' => $manager->id]);
            $managerWallet->increment('balance', $managerAmount);

            WalletTransaction::create([
                'wallet_id' => $managerWallet->id,
                'type' => 'credit',
                'amount' => $managerAmount,
                'description' => "Pemasukan dari {$referenceType} #{$referenceId}",
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);

            // 2. Wallet Sistem (pengembang)
            $systemWallet = Wallet::firstOrCreate(['user_id' => 1]);
            $systemWallet->increment('balance', $fee);

            WalletTransaction::create([
                'wallet_id' => $systemWallet->id,
                'type' => 'credit',
                'amount' => $fee,
                'description' => "Fee aplikasi dari {$referenceType} #{$referenceId}",
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);
        });
    }

    public function processWithdrawal(User $user, float $amount, int $withdrawalId): void
    {
        DB::transaction(function () use ($user, $amount, $withdrawalId) {
            $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->firstOrFail();

            if ($wallet->balance < $amount) {
                throw new \Exception('Saldo tidak mencukupi.');
            }

            $wallet->decrement('balance', $amount);

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'description' => "Penarikan dana (withdrawal #{$withdrawalId})",
                'reference_type' => 'withdrawal',
                'reference_id' => $withdrawalId,
            ]);
        });
    }
}
