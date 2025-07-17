<x-layout.booking title="Detail Booking - Best Desta" section='payment'>
   {{-- SweetAlert2 --}}
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Load Snap.js -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

  <div class="bg-blue-600 text-white px-4 py-3 text-center text-sm">
    Thank you, your booking is being processed! 🎉
  </div>

  <!-- Container -->
  <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Left: Transaction Details -->
    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow border">
      <h2 class="text-xl font-semibold mb-4">Transaction Details</h2>

      <!-- Countdown Timer -->
    @if ($booking->payment_status == 'pending')
      <div id="countdown" data-deadline="{{ $deadline->toIso8601String() }}" class="text-right text-sm text-red-500 font-medium mb-2">
        Time remaining: <span id="timer">--:--:--</span>
      </div>
    @endif

      <!-- Payment Info Box -->
      <div class="bg-gray-50 border rounded-lg overflow-hidden mb-6">
        <div class="bg-gray-100 px-4 py-2 font-semibold flex items-center justify-between">
          <span>Payment via Midtrans</span>
        </div>
        <div class="px-4 py-3 space-y-4 text-sm">
          <div class="flex justify-between items-center">
            <span class="text-gray-600">Booking ID:</span>
            <div class="flex items-center gap-2">
              <span class="font-mono">#{{ $booking->booking_code }}</span>
            </div>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-600">Total Payment:</span>
            <span class="font-semibold text-lg">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-600">Deadline:</span>
            <span class="text-red-600 font-medium">{{ $deadline->locale('en')->translatedFormat('l, d F Y H:i') . ' WITA';}}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-600">Payment Status:</span>
            @if ($booking->payment_status == 'pending')
            <span class="text-yellow-600 font-medium">Waiting for Payment</span>
            @elseif($booking->payment_status == 'settlement')
            <span class="text-green-600 font-medium">Payment Success</span>
            @endif

          </div>
        </div>
      </div>

      <!-- Customer Info -->
      <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Customer Details</h3>
        <div class="text-sm space-y-1">
          <p><strong>Name:</strong> {{ $booking->name }}</p>
          <p><strong>Email:</strong> {{ $booking->email }}</p>
          <p><strong>Phone Number:</strong> {{ $booking->phone }}</p>
          <p><strong>Notes:</strong> {{ $booking->special_req }}</p>
        </div>
      </div>

      <!-- Payment Status Button -->
      <div class="mt-6">
            @if ($booking->payment_status == 'settlement')
            <a href="{{ route('booking.success',$booking->booking_code ) }}"
            class="w-full block text-center bg-green-500 hover:bg-green-600 text-white py-3 rounded text-base font-medium">
             Payment Success
            </a>
            @else
              <button
            id="pay-button"
            class="w-full block text-center bg-orange-500 hover:bg-orange-600 text-white py-3 rounded text-base font-medium">
             @if ($booking->payment_status == 'pending')Pay Now @else Check Payment Status @endif
            </button>
            @endif
      </div>
    </div>

    @if ($items[0]['item_type'] == 'homestay')
    <!-- Right: Homestay Summary -->
     <div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
          <div class="bg-blue-600 text-white px-4 py-2 text-sm font-medium">
            <span class="inline-block align-middle mr-2">🔖</span> You've made a <span class="text-yellow-300 font-bold">great choice</span> for your stay.
          </div>
          <div class="px-4 pt-4 mb-2">
            <h2 class="text-lg font-bold text-gray-800">{{ $items[0]['item_name'] }}</h2>

            @php
                $rating = floatval($items[0]['item_ratings']['rating'] ?? 0);
                $fullStars = floor($items[0]['item_ratings']['rating']);
                $halfStar = $rating - $fullStars >= 0.25 && $rating - $fullStars < 0.75;
                $roundedUp = $rating - $fullStars >= 0.75;
                $totalFull = $fullStars + ($roundedUp ? 1 : 0);
                $emptyStars = 5 - $totalFull - ($halfStar ? 1 : 0);
            @endphp

            @if($rating > 3)
                <div class="flex items-center gap-2 text-sm text-blue-600 mt-2">
                    <!-- Stars -->
                    <div class="flex items-center gap-[2px]">
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star text-yellow-400 text-sm"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="far fa-star text-gray-300 text-sm"></i>
                        @endfor
                        </div>

                        <!-- Rating Number -->
                        <span class="font-semibold text-gray-800">{{ round($rating, 1) }}</span>

                        <!-- Review Count -->
                        <span class="text-gray-500">({{ $items[0]['item_ratings']['rating_count']}})</span>
                    </div>
                </div>
            @endif

            <div class="relative w-full">
                <!-- Carousel -->
                <div class="swiper mySwiper relative">
                    <div class="swiper-wrapper">
                    @foreach($items[0]['item_image'] as $image)
                        <div class="swiper-slide">
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ asset($image->url) }}" alt="room image" class="object-cover w-full h-full rounded-md" />
                        </div>
                        </div>
                    @endforeach
                    </div>

                    <!-- Custom Prev Button -->
                    <div class="absolute inset-y-0 left-1 flex items-center z-10">
                    <div class="swiper-button-prev bg-white/80 hover:bg-white w-5 h-5 rounded-full flex items-center justify-center shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    </div>

                    <!-- Custom Next Button -->
                    <div class="absolute inset-y-0 right-1 flex items-center z-10">
                    <div class="swiper-button-next bg-white/80 hover:bg-white w-5 h-5 rounded-full flex items-center justify-center shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    </div>
                </div>
                </div>

        @php
            $checkin = Carbon\Carbon::parse($booking->details->first()->check_in_date);
            $checkout = Carbon\Carbon::parse($booking->details->first()->check_out_date);

            $diffInNights = $checkin->diffInDays($checkout);
        @endphp
          <div class="px-4 py-4 text-sm">
            <div class="flex items-center justify-between mb-3">
            <div class="flex-1 border border-gray-300 rounded-lg p-3 text-center">
                <div class="text-xs text-gray-500">Check-in</div>
                <div class="font-semibold text-xs text-gray-900">{{ \Carbon\Carbon::parse($checkin)->format('D, d M Y') }}</div>
                <div class="text-xs text-gray-600">From 15:00</div>
            </div>
            <div class="mx-3 text-center">
                <div class="text-xs text-gray-500">{{ $diffInNights}} Night</div>
                <div class="w-16 h-1 flex items-center justify-between mx-auto mt-1">
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                <span class="flex-1 h-0.5 bg-gray-300 mx-1"></span>
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                </div>
            </div>
            <div class="flex-1 border border-gray-300 rounded-lg p-3 text-center">
                <div class="text-xs text-gray-500">Check-out</div>
                <div class="font-semibold text-xs text-gray-900">{{ \Carbon\Carbon::parse($checkout)->format('D, d M Y') }}</div>
                <div class="text-xs text-gray-600">Before 12:00</div>
            </div>
            </div>

            @foreach ($items as $item )
                <h3 class="font-semibold text-base mb-1">({{$item['item_qty']}}x) {{ $item['item_name'] }}</h3>
            @endforeach
            <ul class="space-y-1 text-gray-700 text-sm">
              <li class="flex items-center gap-2">👥 {{ $booking->guest_count }} Guests</li>
            </ul>
            <div class="mt-4 border-t pt-3 text-sm">
              <div class="flex justify-between items-center">
                <div>
                  <p class="font-semibold text-gray-700">🧾 Total Room Price</p>
                  <p class="text-xs text-gray-500">{{ $totalQty}} room(s), {{ $diffInNights}}  night(s)</p>
                </div>
                <div class="text-right">
                  <p class="text-lg font-bold text-orange-600">@currency($booking->total_amount)</p>
                  <p class="text-xs text-green-500">+ Best Offer</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Cancellation Policy -->
        <div class="bg-white mt-4 rounded-lg border border-gray-200 shadow-sm p-4 text-sm">
          <p class="font-semibold mb-1">Cancellation and Reschedule Policy</p>
          <p>This reservation is non-refundable.</p>
          <p class="text-gray-500 text-xs mt-1">Non-reschedulable</p>
        </div>
      </div>
    </div>
    @elseif ($items[0]['item_type'] == 'ticket' || 'tour')
     <div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-red-500 text-white px-4 py-2 text-sm font-semibold flex items-center gap-2">
                <span>📋</span> Booking Summary
            </div>

            <div class="p-4">
                <div class="flex items-center gap-4 mb-4">
                <img src="{{ asset($items[0]['item_image']) }}" alt="{{ $items[0]['item_name'] }}" class="w-16 h-16 rounded-md object-cover">
                <div>
                    <h2 class="text-base font-bold text-gray-800">{{ $items[0]['item_name'] }}</h2>
                    <p class="text-sm text-gray-600">
                       @foreach ($items as $ticket )
                            ✅ {{ $ticket['item_ticket']}}</br>
                        @endforeach
                    </p>
                </div>
                </div>

                <div class="bg-blue-50 rounded-md p-3 text-sm mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Selected Visit Date</span>
                    <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->details->first()->check_in_date)->format('D, d M Y') }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-gray-600">Total Visitors</span>
                    <span class="font-semibold text-gray-900">Pax: {{ $booking->guest_count}}</span>
                </div>
                </div>

                <ul class="text-sm text-gray-700 space-y-1 mb-4">
                <li>🔒 Cannot Be Rescheduled</li>
                <li>🚫 Non-refundable</li>
                </ul>

                <p class="text-xs text-gray-500">For more details about this ticket,
                <a href="#" class="text-blue-600 font-medium underline">see here.</a>
                </p>
            </div>
            </div>


        <!-- Cancellation Policy -->
        <div class="bg-white mt-4 rounded-lg border border-gray-200 shadow-sm p-4 text-sm">
          <p class="font-semibold mb-1">Cancellation and Reschedule Policy</p>
          <p>This reservation is non-refundable.</p>
          <p class="text-gray-500 text-xs mt-1">Non-reschedulable</p>
        </div>
      </div>
    @endif



<!-- Countdown Timer Script -->
<script>
  function startCountdown(deadlineString) {
    const deadline = new Date(deadlineString);
    const timerEl = document.getElementById("timer");

    function updateCountdown() {
      const now = new Date();
      const diff = Math.max(0, deadline - now); // in milliseconds

      const totalSeconds = Math.floor(diff / 1000);
      const hours = Math.floor(totalSeconds / 3600);
      const minutes = Math.floor((totalSeconds % 3600) / 60);
      const seconds = totalSeconds % 60;

      timerEl.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

      if (totalSeconds > 0) {
        setTimeout(updateCountdown, 1000);
      } else {
        timerEl.textContent = "00:00:00";
      }
    }

    updateCountdown();
  }

  // Start countdown using data-deadline attribute
  document.addEventListener("DOMContentLoaded", () => {
    const countdownEl = document.getElementById("countdown");
    const deadlineString = countdownEl.getAttribute("data-deadline");
    startCountdown(deadlineString);
  });
</script>


<!-- Snap JS -->
<script>
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay("{{ $snapToken }}", {
           onSuccess: function(result) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: 'Your payment has been completed successfully.',
                }).then(() => {
                    window.location.href = "/payment/success/{{ $booking->booking_code }}";
                });
            },

            onPending: function(result) {
                Swal.fire({
                    icon: 'info',
                    title: 'Payment Pending',
                    text: 'Your payment is currently being processed.',
                });
            },

            onError: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed',
                    text: 'An error occurred during the payment process.',
                });
            },

            onClose: function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Payment Not Completed',
                    text: 'You closed the popup without completing the payment.',
                });
            }

        });
    });
</script>
</x-layout.booking>
