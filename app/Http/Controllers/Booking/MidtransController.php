<?php

namespace App\Http\Controllers\Booking;

use App\Models\Booking;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        Log::info('⚡ CALLBACK DITERIMA', $request->all());

        $notif = new Notification();

        $orderId           = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $paymentType       = $notif->payment_type;
        $fraudStatus       = $notif->fraud_status;

        $booking = Booking::where('booking_code', $orderId)->first();
        $trx     = Transaction::where('midtrans_order_id', $orderId)->latest()->first();

        if (!$booking || !$trx) {
            Log::warning('📛 Booking tidak ditemukan', ['order_id' => $orderId]);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update status sesuai kondisi transaksi
        if ($transactionStatus === 'settlement') {
            $booking->update(['payment_status' => 'settlement']);
            $trx->update(['payment_status' => 'settlement']);
        } elseif ($transactionStatus === 'pending') {
            $booking->update(['payment_status' => 'pending']);
            $trx->update(['payment_status' => 'pending']);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $booking->update(['payment_status' => $transactionStatus]);
            $trx->update(['payment_status' => $transactionStatus]);
        }

        Log::info('✅ Status diperbarui ke: ' . $transactionStatus);
        return response()->json(['message' => 'Callback handled']);
    }
}
