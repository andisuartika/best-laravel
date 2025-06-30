
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation</title>
</head>
<body style="background-color:#f3f4f6; font-family:Arial, sans-serif; margin:0; padding:20px;">
  <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-top:6px solid #2e7d32; border-radius:12px; overflow:hidden;">
    <tr>
      <td align="center" style="padding:30px 0 10px;">
        <img src="https://ucarecdn.com/acb0a526-3b11-4bcf-8a28-224bfc4bf7c3/logotext.png" alt="Logo" style="max-height:40px;">
      </td>
    </tr>
    <tr>
      <td align="center" style="padding:30px 20px; color:#333;">
        <h2 style="color:#2e7d32; font-size:20px; margin-bottom:25px;">Your booking has been confirmed!</h2>
        <p style="font-size:15px; margin:8px 0;">Hello {{ $guest_name }},</p>
        <p style="font-size:15px; margin:8px 0;">For your reference, your Booking ID is <strong>{{ $booking_code }}</strong>.</p>
        <p style="font-size:15px; margin:8px 0;">You can use our self-service portal to view, cancel, or modify your booking.</p>
        <div style="margin-top:30px;">
          <a href="https://bestdesta.web.id/booking/manage/1460246349" style="background-color:#2563eb; color:white; text-decoration:none; padding:14px 30px; font-size:15px; font-weight:bold; border-radius:30px; display:inline-block;">Manage My Booking</a>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding:20px; color:#333;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:20px;">
          <tr>
            <td style="font-weight:bold; font-size:16px; padding-bottom:10px;">{{ $hotel_name }}</td>
          </tr>
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="width:120px;">
                    <img src="{{ $image }}" alt="Property Image" style="width:120px; border-radius:6px;">
                  </td>
                  <td style="padding-left:15px;">
                    <p style="margin:0;">{{$address}}</p>
                    <p style="margin:0;"><a href="{{ $map_link }}" style="color:#2563eb; text-decoration:none;">View on map</a></p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="border-top:1px solid #e5e7eb; padding-top:15px; padding-bottom:10px;">
              <table width="100%">
                <tr>
                  <td style="width:48%; vertical-align:top;">
                    <strong>Check-in</strong><br>{{ $checkin }}<br><small>(after 3:00 PM)</small>
                  </td>
                  <td style="width:48%; vertical-align:top;">
                    <strong>Check-out</strong><br>{{ $checkout }}<br><small>(before 12:00 PM)</small>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding:20px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="text-align:center; background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:20px;">
          <tr>
            <td>
              <h4>Contact the Property</h4>
              <p>If you have any questions regarding your stay, feel free to contact the property directly.</p>
              <div style="margin:15px 0;">
                <a href="tel:+{{ $manager['phone'] }}" style="display:inline-block; border:1px solid #d1d5db; padding:10px 16px; border-radius:6px; color:#111827; text-decoration:none; margin-right:10px;">📞 {{ $manager['phone'] }}</a>
                <a href="mailto:{{ $manager['email'] }}" style="display:inline-block; border:1px solid #d1d5db; padding:10px 16px; border-radius:6px; color:#111827; text-decoration:none;">✉️ {{ $manager['email'] }}</a>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding:20px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:20px;">
          <tr><td colspan="2"><h4>Booking Details</h4></td></tr>
          <tr><td>Reservation</td><td>: {{ $diffInNight }} night(s), {{ $rooms }} room(s)</td></tr>
          <tr><td>Room Type</td><td>: {{ $item_name }}</td></tr>
          <tr><td>Main Guest</td><td>: {{ $adults }}</td></tr>
          <tr><td>Room Capacity</td><td>: {{ $capacity }} adults</td></tr>
          <tr><td>Benefit</td><td style="color:green; font-weight:bold;">: {{ $promo_benefits }}</td></tr>
          <tr><td>Special Request</td><td>: {{ $note }}<br><span style="font-size:13px; color:#6b7280;">(Subject to availability upon check-in)</span></td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="font-size:13px; text-align:center; color:#666; margin:30px 0 10px;">&copy; 2025 Best Desta. All rights reserved.</td>
    </tr>
  </table>
</body>
</html>
