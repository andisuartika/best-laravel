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
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .subtitle {
            color: #888;
            font-size: 11px;
        }

        .info-wrapper {
            border: 1px solid #e0e0e0;
            padding: 0;
            border-radius: 8px;
            display: table;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
            table-layout: fixed;
        }

        .info-left, .info-right {
            display: table-cell;
            vertical-align: top;
            padding: 15px;
        }

        .info-left {
            width: 65%;
        }

        .info-right {
            width: 35%;
            text-align: center;
            border-left: 1px solid #e0e0e0;
        }

        .info-label {
            color: #888;
            font-size: 10px;
        }

        .info-value {
            font-weight: bold;
        }

        .highlight-box {
            background-color: #f1f3f5;
            padding: 10px;
            border-radius: 6px;
            font-size: 11px;
            color: #333;
            border: 1px solid #d0d7de;
            margin-top: 10px;
        }

        .barcode {
            margin-top: 20px;
        }

        .barcode img {
            width: 100%;
            height: auto;
            max-width: 200px;
        }

        .barcode-number {
            font-size: 12px;
            font-weight: bold;
            margin-top: 8px;
        }

        .price-label {
            font-weight: bold;
            font-size: 13px;
            margin-top: 10px;
        }

        .price {
            color: #0a57ff;
            font-weight: bold;
            font-size: 16px;
        }

        hr {
            margin: 15px 0;
            border: none;
            border-top: 1px solid #ccc;
        }
        .paid {
            background-color: #e7f9eb;
            color: #2e8544;
            border: 1px solid #2e8544;
            border-radius: 4px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="https://ucarecdn.com/acb0a526-3b11-4bcf-8a28-224bfc4bf7c3/logotext.png" alt="Best Desta"  style="width: 150px; height: auto;" >
    </div>
    <p class="small">Please PRINT this voucher and present it during ticket Check In</p>

    <table class="border">
        <tr>
            <td><strong>Order ID</strong>: {{ $booking_code }}</td>
            <td><strong>Item Name</strong>: {{ $name }}</td>
            <td><strong>Date</strong>: {{ $date }}</td>
        </tr>
        <tr>
            <td><strong>Guest Name</strong>: {{ $guest_name }}</td>
            <td><strong>Email</strong>: {{ $email }}</td>
            <td><strong>Status</strong>: <span class="paid">{{ $status }}</span></td>
        </tr>
    </table>

    <div class="blue-bar">TICKETS DETAILS</div>
    <table class="border">
        <tr><td>Destination Name</td><td><strong>{{ $name }}</strong></td></tr>
        @if ($address !== null)
        <tr><td>Address</td><td>{{ $address }}</td></tr>
        @endif
        <tr><td>Date</td><td>{{ $checkin }}</td></tr>
        <tr><td>Promotion</td><td>{{ $promotion }}</td></tr>
    </table>

    <div class="blue-bar">TICKETS DETAILS</div>
     @foreach ($ticket_details as $item)
        <div class="info-wrapper">
            <div class="info-left">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px;">
                    <tr>
                        <td width="50%" valign="top" style="padding-bottom: 8px;">
                            <span class="info-label"><i>Name</i></span><br>
                            <span class="info-value">{{ $guest_name }}</span>
                        </td>
                        <td width="50%" valign="top" style="padding-bottom: 8px;">
                            <span class="info-label"><i>Invoice Code</i></span><br>
                            <span class="info-value">{{ $booking_code }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding-bottom: 8px;">
                            <span class="info-label"><i>Order Date</i></span><br>
                            <span>{{ $date }}</span>
                        </td>
                        <td valign="top" style="padding-bottom: 8px;">
                            <span class="info-label"><i>Reference</i></span><br>
                            <span>Online</span>
                        </td>
                    </tr>
                </table>

                <div class="highlight-box">
                    This is a non-refundable ticket. By completing this purchase, you agree that all sales are final and no refunds will be provided.
                </div>
            </div>
            <div class="info-right">
                <div class="price-label">{{ $item['ticket_name'] }}</div>
                <div class="price">@currency($item['ticket_price'])</div>
                <hr>
                <div class="barcode">
                <div class="qr-box" style="text-align: center; margin-top: 10px;">
                       <img src="data:image/png;base64,{{ $item['qrcode'] }}" alt="QR Code" style="width: 120px; height: auto;">

                        <div style="margin-top: 5px; font-size: 12px; font-weight: bold;">{{ $item['ticket_code'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
