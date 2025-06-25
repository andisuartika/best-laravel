<x-layout.booking title="Booking Page" section='booking'>

  <div class="max-w-6xl mx-auto px-4 py-8 font-sans">
    <div class="mb-6">
      <h1 class="text-2xl font-semibold">Your Accommodation Booking</h1>
      <p class="text-sm text-gray-600">Make sure all the details on this page are correct before proceeding to payment.</p>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Left: Form -->
      <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <form action="{{ route('homestay.booking.store') }}" method="POST">
            @csrf
             <input type="hidden" name="data" value="{{ json_encode($prefillData) }}">
             <h2 class="text-lg font-semibold mb-4">Contact Details (For E-Ticket)</h2>
            <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Contact's name</label>
            <input type="text" class="w-full border rounded px-3 py-2 text-sm" placeholder="e.g John Maeda" name="name" required/>
            {{-- <p class="text-xs text-red-500 mt-1">Please enter a value greater than or equal to 2 character(s).</p> --}}
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Email address</label>
                <input type="email" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" name="email" required/>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Mobile Number</label>
                <div class="flex">
                <select class="border border-gray-300 rounded-l px-2 text-sm" name="phone_country">
                    <option>+62</option>
                    @foreach($countries as $country)
                        <option value="{{ $country['dial_code'] }}">
                            {{ $country['dial_code'] }}
                        </option>
                    @endforeach
                </select>
                <input type="text" class="flex-1 border border-gray-300 rounded-r px-3 py-2 text-sm" placeholder="8123456789" name="phone" required/>
                </div>
            </div>
            </div>

            <h3 class="text-sm font-semibold mb-2">Let us know if you have any request</h3>
            <div class="mb-4">
            <label class="block text-sm font-reguler mb-1">Additional Notes</label>
            <textarea type="text" class="w-full border rounded px-3 py-2 text-sm" name="notes"/></textarea>
            {{-- <p class="text-xs text-red-500 mt-1">Please enter a value greater than or equal to 2 character(s).</p> --}}
            </div>

            <!-- Price Details -->
            <div class="bg-[#f9fbfc] border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-green-600 mb-2">Use coupon at the payment page for cheaper price</p>
            <div class="flex justify-between text-sm mb-1">
                <span class="font-semibold text-base">({{ $prefillData['quantity'] }}x) {{ $roomtypes->name }} - Room Only ({{ $prefillData['diffInNight'] }} Night)</span><span class="font-semibold text-base">@currency($prefillData['total'])</span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span>Taxes and Fees (15%)</span><span>@currency($prefillData['tax'])</span>
            </div>
            <hr>
            <div class="flex justify-between font-bold text-xl mt-2">
                <span>Total price</span><span class="text-orange-600">@currency($prefillData['total_price'])</span>
            </div>

            </div>

            <button type="submit" class="w-full mt-6 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded text-base font-medium">
            Continue to Payment
            </button>
            <p class="text-xs text-center text-gray-500 mt-3">
            By continuing to payment, you agree to Best Desta <a href="#" class="underline">Terms & Conditions</a>, <a href="#" class="underline">Privacy Policy</a>, and <a href="#" class="underline">Accommodation Rules</a>.
            </p>
        </form>

      </div>

      <!-- Right: Sidebar -->
      <div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
          <div class="bg-blue-600 text-white px-4 py-2 text-sm font-medium">
            <span class="inline-block align-middle mr-2">🔖</span> You've made a <span class="text-yellow-300 font-bold">great choice</span> for your stay.
          </div>
          <div class="px-4 pt-4 mb-2">
            <h2 class="text-lg font-bold text-gray-800">{{ $homestay->name }}</h2>

            @php
                $rating = floatval($homestay->ratings->avg('rating') ?? 0);
                $fullStars = floor($rating);
                $halfStar = $rating - $fullStars >= 0.25 && $rating - $fullStars < 0.75;
                $roundedUp = $rating - $fullStars >= 0.75;
                $totalFull = $fullStars + ($roundedUp ? 1 : 0);
                $emptyStars = 5 - $totalFull - ($halfStar ? 1 : 0);
            @endphp

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
                <span class="text-gray-500">({{ $homestay->ratings_count }})</span>
            </div>
            </div>

            <div class="relative w-full">
                <!-- Carousel -->
                <div class="swiper mySwiper relative">
                    <div class="swiper-wrapper">
                    @foreach ($roomtypes->imageRoom as $image)
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


          <div class="px-4 py-4 text-sm">
            <div class="flex items-center justify-between mb-3">
            <div class="flex-1 border border-gray-300 rounded-lg p-3 text-center">
                <div class="text-xs text-gray-500">Check-in</div>
                <div class="font-semibold text-xs text-gray-900">{{ \Carbon\Carbon::parse($prefillData['checkIn'] )->format('D, d M Y') }}</div>
                <div class="text-xs text-gray-600">From 15:00</div>
            </div>
            <div class="mx-3 text-center">
                <div class="text-xs text-gray-500">{{ $prefillData['diffInNight'] }} Night</div>
                <div class="w-16 h-1 flex items-center justify-between mx-auto mt-1">
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                <span class="flex-1 h-0.5 bg-gray-300 mx-1"></span>
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                </div>
            </div>
            <div class="flex-1 border border-gray-300 rounded-lg p-3 text-center">
                <div class="text-xs text-gray-500">Check-out</div>
                <div class="font-semibold text-xs text-gray-900">{{ \Carbon\Carbon::parse($prefillData['checkOut'] )->format('D, d M Y') }}</div>
                <div class="text-xs text-gray-600">Before 12:00</div>
            </div>
            </div>
            <h3 class="font-semibold text-base mb-1">({{ $prefillData['quantity'] }}x) {{ $roomtypes->name }}</h3>
            <ul class="space-y-1 text-gray-700 text-sm">
              <li class="flex items-center gap-2">👥 2 Guests</li>
            </ul>
            <div class="mt-4 border-t pt-3 text-sm">
              <div class="flex justify-between items-center">
                <div>
                  <p class="font-semibold text-gray-700">🧾 Total Room Price</p>
                  <p class="text-xs text-gray-500">{{ $prefillData['quantity'] }} room(s), {{ $prefillData['diffInNight'] }}  night(s)</p>
                </div>
                <div class="text-right">
                  <p class="text-lg font-bold text-orange-600">@currency($prefillData['total'])</p>
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
  </div>

</x-layout.booking>
