<x-layout.booking title="Booking Page">
    <div class="container">
    <h2>Pembayaran untuk Booking #{{ $booking->booking_code }}</h2>
    <p>Total yang harus dibayar: <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong></p>
 <button id="pay-button" class="w-full mt-6 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded text-base font-medium">
           Pay Now
            </button>
</div>

<!-- Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

<script>
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay("{{ $snapToken }}", {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                window.location.href = "/booking/success";
            },
            onPending: function(result) {
                alert('Pembayaran sedang diproses...');
            },
            onError: function(result) {
                alert('Terjadi kesalahan pembayaran.');
            },
            onClose: function() {
                alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
</x-layout.booking>
