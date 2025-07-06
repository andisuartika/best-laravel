<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\TransactionWd;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $banks = Bank::where('user_id', $userId)->get();
        $withdrawals = Withdrawal::where('user_id', $userId)
            ->with('bank')
            ->latest()
            ->get()
            ->map(function ($wd) {
                return [
                    'id'            => $wd->id,
                    'amount'        => number_format($wd->amount, 2, ',', '.'),
                    'status'        => $wd->status,
                    'bank'          => $wd->bank->bank_name . ' - ' . $wd->bank->acc_number,
                    'request_date'  => $wd->request_date->format('d-m-Y H:i'),
                    'note'          => $wd->note,
                ];
            });

        $balance = Wallet::where('user_id', $userId)->first()?->balance ?? 0;

        return view('admin.withdraw', [
            'banks'       => $banks,
            'withdrawals' => $withdrawals,
            'balance'     => $balance,
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'amount'   => 'required|numeric|min:10000',
            'bank_id'  => 'required|exists:banks,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $wallet = Wallet::where('user_id', $userId)->first();
        if (!$wallet || $wallet->balance < $request->amount) {
            return response()->json(['message' => 'Saldo tidak mencukupi.'], 400);
        }

        DB::beginTransaction();

        try {
            // Kurangi saldo langsung
            $wallet->balance -= $request->amount;
            $wallet->save();
            // Simpan withdraw (masih pending)
            $withdraw = Withdrawal::create([
                'user_id'      => $userId,
                'bank_id'      => $request->bank_id,
                'amount'       => $request->amount,
                'status'       => 'pending',
                'request_date' => now(),
            ]);

            // Catat log permintaan
            TransactionWd::create([
                'withdrawal_id' => $withdraw->id,
                'amount'      => $request->amount,
                'status'      => 'pending',
            ]);


            DB::commit();

            return response()->json(['message' => 'Withdraw berhasil dikirim.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat withdraw.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function listWithdraw()
    {
        $withdrawals = Withdrawal::with(['user', 'bank'])
            ->latest()
            ->get()
            ->map(function ($wd) {
                return [
                    'id'           => $wd->id,
                    'user'         => $wd->user->name,
                    'bank'         => $wd->bank->bank_name,
                    'acc_number'   => $wd->bank->acc_number,
                    'acc_holder'   => $wd->bank->acc_holder,
                    'amount'       => $wd->amount,
                    'status'       => $wd->status,
                    'request_date' => $wd->request_date->format('Y-m-d H:i'),
                    'payment_method' => $wd->payment_method,
                    'payment_ref'    => $wd->payment_ref,
                ];
            });

        return view('admin.list-withdraw', [
            'withdrawals' => $withdrawals
        ]);
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string|max:255',
            'payment_ref'    => 'required|string|max:255',
        ]);

        $withdraw = Withdrawal::with('user')->findOrFail($id);
        $transactionWd = TransactionWd::where('withdrawal_id', $withdraw->id)->first();
        $wallet = Wallet::where('user_id', $withdraw->user_id)->lockForUpdate()->first();

        if ($withdraw->status !== 'pending') {
            return response()->json(['message' => 'Withdraw sudah diproses.'], 400);
        }

        DB::beginTransaction();
        try {
            // Simpan data approval
            $withdraw->update([
                'status'          => 'approved',
                'approval_date'     => now(),
                'payment_date'     => now(),
            ]);

            // Simpan transaksi wallet (debit)
            WalletTransaction::create([
                'user_id' => $withdraw->user_id,
                'wallet_id' => $wallet->id,
                'type'    => 'debit',
                'amount'  => $withdraw->amount,
                'description'    => 'Withdraw approved',
                'refrence_type'  => 'withdrawal',
                'refrence_id'  => $withdraw->id,
            ]);

            // Update log transaksi withdraw
            $transactionWd->update([
                'status'          => 'paid',
                'payment_method'  => $request->payment_method,
                'payment_ref'     => $request->payment_ref,
            ]);


            DB::commit();
            return response()->json(['message' => 'Withdraw disetujui.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyetujui withdraw.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $withdraw = Withdrawal::findOrFail($id);
        $transactionWd = TransactionWd::where('withdrawal_id', $withdraw->id)->first();

        if ($withdraw->status !== 'pending') {
            return response()->json(['message' => 'Withdraw sudah diproses.'], 400);
        }

        DB::beginTransaction();
        try {
            // Update status dan simpan alasan
            $withdraw->update([
                'status' => 'rejected',
                'note'   => $request->note,
            ]);

            // Refund saldo
            $wallet = Wallet::where('user_id', $withdraw->user_id)->lockForUpdate()->first();
            $wallet->balance += $withdraw->amount;
            $wallet->save();

            $transactionWd->update([
                'status'  => 'failed',
            ]);

            DB::commit();
            return response()->json(['message' => 'Withdraw ditolak.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menolak withdraw.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
