<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\TicketDetail;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        //wallet
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        $netTotal = WalletTransaction::where('wallet_id', $wallet->id)
            ->whereDate('created_at', today())
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN type = 'credit' THEN amount
                                WHEN type = 'debit' THEN -amount
                                ELSE 0
                            END
                        ) as net_total
                    ")
            ->value('net_total');
        $netStatus = $netTotal > 0 ? 'plus' : ($netTotal < 0 ? 'minus' : 'neutral');

        //chart donut
        $summaryByItemType = DB::table('booking_details')
            ->join('bookings', 'booking_details.booking', '=', 'bookings.id')
            ->where('bookings.booking_status', 'paid')
            ->select('booking_details.item_type', DB::raw('SUM(bookings.total_amount) as total'))
            ->groupBy('booking_details.item_type')
            ->pluck('total', 'item_type');

        $tour       = (float) ($summaryByItemType['tour'] ?? 0);
        $destinasi  = (float) ($summaryByItemType['destination'] ?? 0);
        $akomodasi  = (float) ($summaryByItemType['akomodasi'] ?? 0);
        $totalTransaksi = $tour + $destinasi + $akomodasi;

        //chart lines
        $ticketsChart = TicketDetail::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6)) // 7 hari terakhir
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        //tabel booking
        $booking = Booking::where('manager', Auth::user()->id)->latest()->take(5)->get();

        //tabel transaction
        $managerId = Auth::user()->id;
        $transactions = Transaction::with('book')->whereHas('book', function ($query) use ($managerId) {
            $query->where('manager', $managerId);
        })->latest()->take(5)->get();


        $data = [
            'balance' => $wallet->balance ?? 0,
            'net_today' => $netTotal ?? 0,
            'net_status' => $netStatus,
            'total_transaction' => $totalTransaksi,
            'pie_chart' => [
                'labels' => ['Tour', 'Destination', 'Homestay'],
                'series' => [$tour, $destinasi, $akomodasi],
            ],
            'ticket_chart' => [
                'dates' => ['29 Jun', '30 Jun', '01 Jul', '02 Jul', '03 Jul', '04 Jul', '05 Jul'],
                'totals' => [2, 4, 6, 3, 7, 5, 3],
            ],
            'transaction_monthly' => [
                'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                'totals' => [5000000, 4200000, 6100000, 3000000, 7200000, 6500000, 4300000]
            ],
            'total_ticket' => 30,
            'booking' => $booking ?? null,
            'transactions' => $transactions ?? null,
        ];



        return view('admin.dashboard', compact('data'));
    }
}
