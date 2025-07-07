<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Transaction;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery;
use App\Services\MidtransService;

class BookingDestinationControllerTest extends TestCase
{
    public function test_store_booking_successfully()
    {
        // Mock MidtransService
        $mockMidtrans = Mockery::mock(MidtransService::class);
        $mockMidtrans->shouldReceive('getSnapToken')
            ->once()
            ->andReturn('dummy_snap_token');

        $this->app->instance(MidtransService::class, $mockMidtrans);


        // ✅ Ambil Destination dari database
        $destination = Destination::where('slug', 'gatep-lawas')->first();
        $this->assertNotNull($destination, 'Destination dengan slug "gatep-lawas" tidak ditemukan di database.');

        // Hitung jumlah awal
        $bookingCountBefore = Booking::count();
        $detailCountBefore = BookingDetail::count();
        $transactionCountBefore = Transaction::count();

        // Siapkan request
        $requestData = [
            'name'  => 'Destination Testing',
            'email' => 'destination@testing.com',
            'phone' => '08123456789',
            'phone_country' => '+62',
            'notes' => 'Test note',
            'data'  => json_encode([
                'slug'        => 'gatep-lawas',
                'pax'         => 2,
                'total_price' => 100000,
                'ticket_date' => now()->toDateString(),
                'ticket' => [
                    [
                        'code'     => 'TK001',
                        'quantity' => 2,
                        'price'    => 50000,
                        'subtotal' => 100000,
                    ],
                ]
            ]),
        ];

        $response = $this->post('/booking/destination', $requestData);

        // ✅ Cek hanya data yang ditambahkan
        $this->assertEquals($bookingCountBefore + 1, Booking::count(), 'Booking tidak bertambah.');
        $this->assertEquals($detailCountBefore + 1, BookingDetail::count(), 'BookingDetail tidak bertambah.');
        $this->assertEquals($transactionCountBefore + 1, Transaction::count(), 'Transaction tidak bertambah.');

        $this->assertDatabaseHas('bookings', [
            'email' => 'destination@testing.com',
            'total_amount' => 100000,
        ]);

        $this->assertDatabaseHas('transactions', [
            'payment_method' => 'midtrans',
        ]);

        $response->assertRedirectContains('/booking/pay/');
        // $response->dump();
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
