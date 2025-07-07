<?php

namespace App\Http\Controllers\Booking;

use App\Models\Booking;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\VoucherSender;
use App\Services\TicketGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\WalletService;

class MidtransController extends Controller
{
    public function callback(Request $request, WalletService $walletService)
    {
        Log::info('⚡ CALLBACK DITERIMA', $request->all());

        try {
            // ✅ Kirim response cepat ke Midtrans
            $this->respondImmediately();

            // ✅ Jalankan proses berat setelahnya
            $this->handleMidtrans($walletService);
        } catch (\Throwable $e) {
            Log::error('❌ Callback GAGAL: ' . $e->getMessage());
        }
    }

    private function respondImmediately()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $response = json_encode(['message' => 'Callback received']);

        header('Content-Type: application/json');
        header('Connection: close');
        header('Content-Length: ' . strlen($response));

        // Kirim respons dulu, lalu flush
        echo $response;

        ob_end_flush();
        flush();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }


    private function handleMidtrans(WalletService $walletService)
    {
        $notif = new Notification();

        $orderId = $notif->order_id;
        $transactionStatus = $notif->transaction_status;

        $booking = Booking::with('user')->where('booking_code', $orderId)->first();
        $transaction = Transaction::where('midtrans_order_id', $orderId)->latest()->first();

        if (!$booking || !$transaction) {
            Log::warning('📛 Booking tidak ditemukan', ['order_id' => $orderId]);
            return;
        }

        if ($transactionStatus === 'settlement') {
            DB::transaction(function () use ($booking, $transaction, $walletService) {
                $booking->update([
                    'payment_status' => 'settlement',
                    'booking_status' => 'paid',
                ]);

                $transaction->update(['payment_status' => 'settlement']);

                // 🎟️ Buat tiket
                TicketGenerator::generate($booking);

                // 📧 Kirim voucher
                VoucherSender::send($booking, $transaction);

                // 💰 Tambahkan saldo wallet pengelola
                $walletService->processBooking(
                    $booking->user,
                    $transaction->amount,
                    'booking',
                    $booking->id
                );
            });
        } elseif ($transactionStatus === 'pending') {
            $booking->update(['payment_status' => 'pending']);
            $transaction->update(['payment_status' => 'pending']);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $booking->update([
                'payment_status' => $transactionStatus,
                'booking_status' => $transactionStatus,
            ]);
            $transaction->update(['payment_status' => $transactionStatus]);
        }

        Log::info('✅ Callback selesai diproses (async): ' . $transactionStatus);
    }


    // public function callback(Request $request, WalletService $walletService)
    // {
    //     Log::info('⚡ CALLBACK DITERIMA', $request->all());

    //     $notif = new Notification();

    //     $orderId           = $notif->order_id;
    //     $transactionStatus = $notif->transaction_status;
    //     $booking = Booking::with('user')->where('booking_code', $orderId)->first();
    //     $transaction     = Transaction::where('midtrans_order_id', $orderId)->latest()->first();

    //     if (!$booking || !$transaction) {
    //         Log::warning('📛 Booking tidak ditemukan', ['order_id' => $orderId]);
    //         return response()->json(['message' => 'Booking not found'], 404);
    //     }

    //     // Update status sesuai kondisi transaksi
    //     if ($transactionStatus === 'settlement') {
    //         DB::transaction(function () use ($booking, $transaction, $walletService) {
    //             $booking->update([
    //                 'payment_status' => 'settlement',
    //                 'booking_status' => 'paid',
    //             ]);
    //             $transaction->update(['payment_status' => 'settlement']);

    //             TicketGenerator::generate($booking);
    //             VoucherSender::send($booking, $transaction);

    //             $manager = $booking->user;
    //             $walletService->processBooking(
    //                 $manager,
    //                 $transaction->amount,
    //                 'booking',
    //                 $booking->id
    //             );
    //         });
    //     } elseif ($transactionStatus === 'pending') {
    //         $booking->update(['payment_status' => 'pending']);
    //         $transaction->update(['payment_status' => 'pending']);
    //     } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
    //         $booking->update(['payment_status' => $transactionStatus, 'booking_status' => $transactionStatus]);
    //         $transaction->update(['payment_status' => $transactionStatus]);
    //     }

    //     Log::info('✅ Status diperbarui ke: ' . $transactionStatus);
    //     return response()->json(['message' => 'Callback handled']);
    // }
}
