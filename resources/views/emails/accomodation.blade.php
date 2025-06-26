<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation</title>
  <style>
    body {
      background-color: #f3f4f6;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    .email-wrapper {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      border-top: 6px solid #2e7d32;
    }
    .logo {
      text-align: center;
      padding: 30px 0 10px;
    }
    .logo img {
      max-height: 40px;
    }
    .content {
      text-align: center;
      padding: 30px 20px;
      color: #333;
    }
    .content h2 {
      color: #2e7d32;
      font-size: 20px;
      margin-bottom: 25px;
    }
    .content p {
      font-size: 15px;
      margin: 8px 0;
    }
    .button {
      margin-top: 30px;
    }
    .button a {
      background-color: #2563eb;
      color: white;
      text-decoration: none;
      padding: 14px 30px;
      font-size: 15px;
      font-weight: bold;
      border-radius: 30px;
      display: inline-block;
    }
    .section {
      padding: 20px;
      color: #333;
    }
    .booking-details,
    .contact-section,
    .order-info {

      background-color: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 20px;
      margin: 20px;
    }
    .contact-section{
        text-align: center;
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
      margin: 30px 0 10px;
    }
    a {
      color: #2563eb;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <!-- Logo -->
    <div class="logo">
      <img src="https://ucarecdn.com/acb0a526-3b11-4bcf-8a28-224bfc4bf7c3/logotext.png" alt="Logo">
    </div>

    <!-- Header -->
    <div class="content">
      <h2>Your booking has been confirmed!</h2>
      <p>Hello {{ $guest_name }},</p>
      <p>For your reference, your Booking ID is <strong>{{ $booking_code }}</strong>.</p>
      <p>You can use our self-service portal to view, cancel, or modify your booking.</p>
      <div class="button">
        <a href="https://bestdesta.web.id/booking/manage/1460246349">Manage My Booking</a>
      </div>
    </div>

    <!-- Booking Details -->
    <div class="section booking-details">
      <div class="property-header">{{ $hotel_name }}</div>
      <div class="property-info">
        <div class="property-image">
          <img src="{{ $image }}" alt="Property Image">
        </div>
        <div>
          <p>{{$address}}</p>
          <p><a href="{{ $map_link }}">View on map</a></p>
        </div>
      </div>
      <div class="dates">
        <div>
          <strong>Check-in</strong><br>
          {{ $checkin }}<br>
          <small>(after 3:00 PM)</small>
        </div>
        <div>
          <strong>Check-out</strong><br>
          {{ $checkout }}<br>
          <small>(before 12:00 PM)</small>
        </div>
      </div>
    </div>

    <!-- Contact Section -->
    <div class="section contact-section">
      <h4>Contact the Property</h4>
      <p>If you have any questions regarding your stay, feel free to contact the property directly.</p>
      <div class="contact-buttons">
        <a class="contact-button" href="tel:+{{ $manager['phone'] }}">📞 {{ $manager['phone'] }}</a>
        <a class="contact-button" href="mailto:{{ $manager['email'] }}">✉️ {{ $manager['email'] }}</a>
      </div>
    </div>

    <!-- Order Information -->
    <div class="section order-info">
      <h4>Booking Details</h4>
      <table>
        <tr><td>Reservation</td><td>: {{ $diffInNight }} night(s), {{ $rooms }} room(s)</td></tr>
        <tr><td>Room Type</td><td>: {{ $item_name }}</td></tr>
        <tr><td>Main Guest</td><td>: {{ $adults }}</td></tr>
        <tr><td>Room Capacity</td><td>: {{ $capacity }} adults</td></tr>
        <tr><td>Benefit</td><td><span class="highlight-green">: {{ $promo_benefits }}</span></td></tr>
        <tr><td>Special Request</td><td>: {{ $note }}<br><span class="note">(Subject to availability upon check-in)</span></td></tr>
      </table>
    </div>

    <!-- Footer -->
    <div class="footer">
      &copy; 2025 Best Desta. All rights reserved.
    </div>
  </div>
</body>
</html>
