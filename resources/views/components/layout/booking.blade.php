<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $title ?? 'Booking Form' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>
<!-- Swiper CSS -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
  .swiper-button-next::after,
  .swiper-button-prev::after {
    content: none !important;
  }
</style>


</head>
<body class="bg-[#f4f6f8] text-gray-800">
  <!-- Navbar with steps -->
  <nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex text-xl font-bold text-blue-600">
        <img class="w-8 ml-[5px] flex-none" src="/assets/images/logo.svg" alt="image" /> BEST DESTA
      </div>
      @php
            $isPayActive = in_array($section, ['payment', 'booking', 'success']);
        @endphp

        <div class="flex items-center space-x-4 text-sm text-gray-600">
        @foreach ([
            ['label' => 'Fill in data', 'active' => true],
            ['label' => 'Pay', 'active' => $isPayActive],
            ['label' => 'Voucher Sent', 'active' => $section === 'success']
        ] as $i => $step)
            <div class="flex items-center space-x-1">
            <span class="{{ $step['active'] ? 'font-semibold text-blue-600' : '' }}">{{ $step['label'] }}</span>
            @if ($i < 2) <span>→</span> @endif
            </div>
        @endforeach
        </div>

    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-4 py-8 font-sans">
    {{ $slot }}
  </main>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
      loop: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  });
</script>




</html>
