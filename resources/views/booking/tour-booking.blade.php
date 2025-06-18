<x-layout.booking title="Booking Page">

  <div class="max-w-6xl mx-auto px-4 py-8 font-sans">
    <div class="mb-6">
      <h1 class="text-2xl font-semibold">Your Ticket(s) Booking</h1>
      <p class="text-sm text-gray-600">Fill in your details and review your booking.</p>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Left: Form -->
      <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <form action="" method="POST">
            @csrf
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
                <select class="border border-gray-300 rounded-l px-2 text-sm">
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
            @foreach ($prefillData['ticket'] as $ticket )
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-normal text-base">({{ $ticket['quantity'] }}x) {{ $ticket['name'] }}</span><span class="font-normal text-base">@currency($ticket['subtotal'])</span>
                </div>
            @endforeach
            <hr>
             <div class="flex justify-between text-sm mb-1">
                <span class="font-semibold text-base">Sub Total</span><span class="font-semibold text-base">@currency($prefillData['total'])</span>
             </div>
            <div class="flex justify-between text-sm my-2">
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
            <div class="bg-red-500 text-white px-4 py-2 text-sm font-semibold flex items-center gap-2">
                <span>📋</span> Booking Summary
            </div>

            <div class="p-4">
                <div class="flex items-center gap-4 mb-4">
                <img src="{{ asset($tour->thumbnail) }}" alt="Dufan" class="w-16 h-16 rounded-md object-cover">
                <div>
                    <h2 class="text-base font-bold text-gray-800">{{ $tour->name }}</h2>
                    <p class="text-sm text-gray-600">
                         @foreach ($prefillData['ticket'] as $ticket )
                         ✅ {{ $ticket['name'] }}</br>
                        @endforeach
                    </p>
                </div>
                </div>

                <div class="bg-blue-50 rounded-md p-3 text-sm mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Selected Visit Date</span>
                    <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($prefillData['ticket_date'] )->format('D, d M Y') }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-gray-600">Total Visitors</span>
                    <span class="font-semibold text-gray-900">Pax: {{ $prefillData['pax'] }}</span>
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
    </div>
  </div>

</x-layout.booking>
