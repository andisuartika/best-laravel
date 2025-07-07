<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Transaction;
use App\Models\Homestay;
use App\Models\RoomType;
use App\Services\MidtransService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Mockery;

class BookingAccommodationControllerTest extends TestCase
{
    public function test_store_booking_accommodation_successfully()
    {
        // ✅ Mock MidtransService
        $mockMidtrans = Mockery::mock(MidtransService::class);
        $mockMidtrans->shouldReceive('getSnapToken')
            ->once()
            ->andReturn('dummy_snap_token');
        $this->app->instance(MidtransService::class, $mockMidtrans);

        // ✅ Ambil RoomType dan Homestay dari DB
        $room = RoomType::whereNotNull('code')->first();
        $this->assertNotNull($room, 'RoomType tidak ditemukan.');

        $homestay = Homestay::where('code', $room->homestay)->first();
        $this->assertNotNull($homestay, 'Homestay untuk RoomType tersebut tidak ditemukan.');

        // Hitung jumlah awal
        $bookingBefore = Booking::count();
        $detailBefore = BookingDetail::count();
        $trxBefore = Transaction::count();

        // Simulasi data request
        $requestData = [
            'name'  => 'Homestay testing',
            'email' => 'homestay@test.com',
            'phone' => '08123456789',
            'phone_country' => '+62',
            'notes' => 'Non-smoking room',
            'data' => json_encode([
                'code'       => $room->code,
                'quantity'   => 2,
                'roomPrice'  => 300000,
                'checkIn'    => now()->addDays(1)->toDateString(),
                'checkOut'   => now()->addDays(3)->toDateString(),
                'total'      => 600000,
                'total_price' => 600000,
            ]),
        ];

        // Kirim request
        $response = $this->post('/booking/homestay', $requestData);

        // Validasi pertambahan data
        $this->assertEquals($bookingBefore + 1, Booking::count());
        $this->assertEquals($detailBefore + 1, BookingDetail::count());
        $this->assertEquals($trxBefore + 1, Transaction::count());

        // Validasi isi data booking
        $this->assertDatabaseHas('bookings', [
            'email' => 'homestay@test.com',
            'total_amount' => 600000,
        ]);

        $this->assertDatabaseHas('transactions', [
            'payment_token' => 'dummy_snap_token',
            'payment_method' => 'midtrans',
        ]);

        // Validasi redirect ke halaman pembayaran
        $response->assertRedirectContains('/booking/pay/');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
