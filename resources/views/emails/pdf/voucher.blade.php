<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>Homestay Voucher</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #000; margin: 30px; }
        h1, h2 { margin: 0; }
        .header { text-align: right; margin-bottom: 10px; }
        .section { margin-bottom: 20px; }
        .blue-bar { background-color: #004990; color: #fff; padding: 6px 10px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px 6px; vertical-align: top; }
        .border { border: 1px solid #ccc; margin-bottom: 10px; }
        .label { background-color: #f0f0f0; padding: 6px; font-weight: bold; }
        .value { padding: 6px; }
        .confirmed { color: orange; font-weight: bold; }
        .footer { font-size: 10px; color: #555; text-align: center; border-top: 1px solid #ccc; padding-top: 10px; margin-top: 20px; }
        .signature img { height: 50px; margin-top: 10px; }
        .logo img { height: 28px; }
        .small { font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="logo">
        <img src="https://ucarecdn.com/acb0a526-3b11-4bcf-8a28-224bfc4bf7c3/logotext.png" alt="Best Desta"  style="width: 150px; height: auto;" >
    </div>
    <p class="small">Please PRINT this voucher and present it during hotel CHECK-IN.</p>

    <table class="border">
        <tr>
            <td><strong>Order ID</strong>: {{ $booking_code }}</td>
            <td><strong>Item Number</strong>: {{ $item_code }}</td>
            <td><strong>Date</strong>: {{ $date }}</td>
        </tr>
        <tr>
            <td><strong>Guest Name</strong>: {{ $guest_name }}</td>
            <td colspan="2"><strong>Email</strong>: {{ $email }} <span class="confirmed">{{ $status }}</span></td>
        </tr>
    </table>

    <div class="blue-bar">HOMESTAY DETAILS</div>
    <table class="border">
        <tr><td>Hotel Name</td><td><strong>{{ $hotel_name }}</strong></td></tr>
        <tr><td>Room Type</td><td>{{ $room_type }}</td></tr>
        <tr><td>Address</td><td>{{ $address }}</td></tr>
        <tr><td>Check-in</td><td>{{ $checkin }} From 15:00</td></tr>
        <tr><td>Check-out</td><td>{{ $checkout }} Before 12:00</td></tr>
        <tr><td>Promotion</td><td>{{ $promotion }}</td></tr>
    </table>

    <table class="border">
        <tr>
            <td>Number of Rooms</td><td>{{ $rooms }}</td>
            <td>Extra Bed</td><td>{{ $extra_bed }}</td>
        </tr>
        <tr>
            <td>Adults</td><td>{{ $adults }}</td>

        </tr>
        <tr>
            <td>Breakfast</td><td>{{ $breakfast }}</td>
            <td>Included</td><td>{{ $inclusions }}</td>
        </tr>
        <tr>
            <td>Promo Benefits</td><td colspan="3">{{ $promo_benefits }}</td>
        </tr>
    </table>

    <div class="blue-bar">PAYMENT METHOD</div>
    <table class="border">
        <tr><td>Payment Type</td><td>{{ $payment_type }}</td></tr>
    </table>

    <div class="signature">
        <p>Authorized Signature and Stamp</p>
        <img src="https://ucarecdn.com/f6166f8b-fd68-4ff9-8d88-977cf79d67cf/stempel.png" alt="Booking Engine System"  style="width:200px; height: auto;" >
    </div>

    <div class="footer">
        If you need assistance, contact bestdesta.web.id at <strong>085 123 456  78</strong> or <strong>info@bestdesta.web.id</strong><br>
        Booking Engine System, Buleleng, Bali
    </div>
</body>
</html>
