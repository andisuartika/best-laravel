
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f4f6;
      margin: 0;
      padding: 20px;
    }
    .email-container {
      max-width: 600px;
      margin: auto;
      background: #ffffff;
      border-radius: 8px;
      padding: 20px;
    }
    .header {
      text-align: center;
      padding: 30px 20px;
      background-color: #e6f4ea;
      border-top: 5px solid #2ecc71;
      border-radius: 8px 8px 0 0;
    }
    .header h2 {
      color: #2ecc71;
      margin: 0;
      font-size: 20px;
    }
    .content {
      padding: 20px;
      color: #333;
    }
    .content p {
      font-size: 15px;
    }
    .button {
      display: inline-block;
      background-color: #2563eb;
      color: white;
      text-decoration: none;
      padding: 12px 20px;
      border-radius: 6px;
      font-weight: bold;
      margin-top: 15px;
    }
    .booking-details {
      background-color: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 20px;
      margin-top: 20px;
    }
    .property-header {
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 10px;
    }
    .property-info {
      display: flex;
      align-items: flex-start;
      gap: 15px;
    }
    .property-image img {
      width: 120px;
      border-radius: 6px;
    }
    .dates {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      border-top: 1px solid #e5e7eb;
      padding-top: 15px;
    }
    .dates div {
      width: 48%;
    }
    .contact-section {
      margin-top: 30px;
      padding: 20px;
      background-color: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
    }
    .contact-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 15px 0;
    }
    .contact-button {
      display: inline-block;
      border: 1px solid #d1d5db;
      padding: 10px 16px;
      border-radius: 6px;
      text-align: center;
      color: #111827;
      text-decoration: none;
    }
    .order-info {
      margin-top: 30px;
      padding: 20px;
      background-color: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
    }
    .order-info h4 {
      margin-top: 0;
    }
    .order-info table {
      width: 100%;
      border-collapse: collapse;
    }
    .order-info td {
      padding: 8px 0;
      border-bottom: 1px solid #e5e7eb;
    }
    .highlight-green {
      color: green;
      font-weight: bold;
    }
    .note {
      font-size: 13px;
      color: #6b7280;
    }
    .footer {
      font-size: 13px;
      text-align: center;
      color: #666;
      margin-top: 30px;
    }
    a {
      color: #2563eb;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h2>Your booking has been confirmed!</h2>
    </div>

    <div class="content">
      <p>Hello {{ $user_name }},</p>
      <p>As a reference, your booking ID is <strong>{{ $booking_id }}</strong>. Please use our self-service portal to view, modify, or cancel your booking.</p>
      <a href="{{ $manage_booking_link }}" class="button">Manage My Booking</a>

      <div class="booking-details">
        <div class="property-header">{{ $property_name }}</div>
        <div class="property-info">
          <div class="property-image">
            <img src="{{ $property_image_url }}" alt="Property Image">
          </div>
          <div>
            <p>{{ $property_address }}</p>
            <p><a href="{{ $map_link }}">View on map</a></p>
          </div>
        </div>

        <div class="dates">
          <div>
            <strong>Check-in</strong><br>
            {{ $checkin_date }}<br>
            <small>(after 2:00 PM)</small>
          </div>
          <div>
            <strong>Check-out</strong><br>
            {{ $checkout_date }}<br>
            <small>(before 12:00 PM)</small>
          </div>
        </div>
      </div>

      <div class="contact-section">
        <h4>Contact the Property</h4>
        <p>If you have any questions regarding your stay, feel free to contact the property directly.</p>
        <div class="contact-buttons">
          <a class="contact-button" href="tel:{{ $phone_number }}">📞 {{ $phone_number }}</a>
          <a class="contact-button" href="mailto:{{ $email_address }}">✉️ {{ $email_address }}</a>
        </div>
        <p class="note"><strong>Important Info:</strong><br>{{ $important_note }}</p>
      </div>

      <div class="order-info">
        <h4>Booking Details</h4>
        <table>
          <tr><td>Reservation</td><td>{{ $nights }} night(s), {{ $rooms }} room(s)</td></tr>
          <tr><td>Room Type</td><td>{{ $room_type }}</td></tr>
          <tr><td>Promotion</td><td>{{ $promotion }}</td></tr>
          <tr><td>Main Guest</td><td>{{ $guest_name }}</td></tr>
          <tr><td>Room Capacity</td><td>{{ $capacity }}</td></tr>
          <tr><td>Benefit</td><td><span class="highlight-green">{{ $benefit }}</span></td></tr>
          <tr><td>Special Request</td><td>{{ $special_request }}<br><span class="note">(Subject to availability upon check-in)</span></td></tr>
        </table>
      </div>
    </div>

    <div class="footer">
      &copy; {{ date('Y') }} Best Desta. All rights reserved.
    </div>
  </div>
</body>
</html>

