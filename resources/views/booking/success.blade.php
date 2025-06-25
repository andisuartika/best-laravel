<x-layout.booking title="Success - Best Desta" section='success'>

  <!-- Notification Bar -->
  <div class="bg-green-600 text-white px-4 py-3 text-center text-sm">
    🎉 Payment Successful! Your booking has been confirmed.
  </div>

  <!-- Container -->
  <div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-lg shadow-md p-6">

      <!-- Success Message -->
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4" />
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Completed!</h2>
        <p class="text-gray-600 mb-4">Thank you for booking with Best Desta. We have sent your e-ticket and booking confirmation to your email.</p>
      </div>

      <!-- Booking Summary -->
      <div class="mt-6 border-t pt-6">
        <h3 class="text-lg font-semibold mb-4">Booking Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div>
            <p><strong>Guest Name:</strong> {{ $booking->name}}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Phone:</strong> {{ $booking->phone }}</p>
          </div>
          @if ($booking->details->first()->item_type =='homestay')
          <div>
            <p><strong>Homestay:</strong> {{ $items[0]['item_details']->homestays->name }}</p>
            <p><strong>Room:</strong> {{ $items[0]['item_name'] }}</p>
            <p><strong>Guests:</strong> {{ $booking->guest_count }}</p>
          </div>
          @endif
          <div>
            <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->details->first()->check_in_date)->format('D, d M Y') }} from 15:00</p>
            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->details->first()->check_out_date)->format('D, d M Y') }}before 12:00</p>
          </div>
          <div>
            <p><strong>Total Paid:</strong> <span class="font-bold text-orange-600">Rp @currency($booking->total_amount)</span></p>
            <p><strong>Booking ID:</strong> #{{ $booking->booking_code }}</p>
          </div>
        </div>
      </div>

      <!-- Back to Home Button -->
      <div class="mt-8 text-center">
        <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded">
          Back to Homepage
        </a>
      </div>

    </div>
  </div>

</x-layout.booking>
