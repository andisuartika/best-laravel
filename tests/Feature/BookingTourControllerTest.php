<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Transaction;
use App\Models\Tour;
use App\Models\TourRate;
use Illuminate\Support\Str;
use Mockery;
use App\Services\MidtransService;

class BookingTourControllerTest extends TestCase
{
    public function test_store_booking_tour_successfully()
    {
        // Mock Midtrans
        $mockMidtrans = Mockery::mock(MidtransService::class);
        $mockMidtrans->shouldReceive('getSnapToken')
            ->once()
            ->andReturn('dummy_snap_token');

        $this->app->instance(MidtransService::class, $mockMidtrans);


        // Ambil Tour dan TourRate dari database
        $tour = Tour::where('slug', 'ambengan-tour')->first();
        $this->assertNotNull($tour, 'Tour dengan slug "example-tour" tidak ditemukan.');

        $rate = TourRate::where('tour', $tour->code)->first();
        $this->assertNotNull($rate, 'TourRate untuk tour tersebut tidak ditemukan.');

        $bookingCountBefore = Booking::count();
        $detailCountBefore = BookingDetail::count();
        $transactionCountBefore = Transaction::count();

        $requestData = [
            'name'  => 'Tour Testing',
            'email' => 'tour@testing.com',
            'phone' => '082345678901',
            'notes' => 'No special request',
            'data'  => json_encode([
                'slug'        => $tour->slug,
                'pax'         => 2,
                'total_price' => 200000,
                'ticket_date' => now()->toDateString(),
                'ticket' => [
                    [
                        'id'       => $rate->id,
                        'quantity' => 2,
                        'price'    => 100000,
                        'subtotal' => 200000,
                    ],
                ]
            ]),
        ];

        $response = $this->post('/booking/tour', $requestData);

        $this->assertEquals($bookingCountBefore + 1, Booking::count());
        $this->assertEquals($detailCountBefore + 1, BookingDetail::count());
        $this->assertEquals($transactionCountBefore + 1, Transaction::count());

        $this->assertDatabaseHas('bookings', [
            'email' => 'tour@testing.com',
            'total_amount' => 200000,
        ]);

        $this->assertDatabaseHas('transactions', [
            'payment_token' => 'dummy_snap_token',
            'payment_method' => 'midtrans',
        ]);

        $response->assertRedirectContains('/booking/pay/');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
