<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Ticket Confirmation</title>
  </head>
  <body style="margin:0; padding:0; background-color:#eef3fb; font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
      <tr>
        <td align="center">
          <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:12px; overflow:hidden;">
            <!-- Header -->
            <tr>
              <td align="center" style="padding-top:40px; background-color:#eef3fb;">
                <img src="https://ucarecdn.com/acb0a526-3b11-4bcf-8a28-224bfc4bf7c3/logotext.png" alt="Logo" style="height:80px;" />
              </td>
            </tr>
            <tr>
              <td style="height:8px; background-color:#0e2654;"></td>
            </tr>

            <!-- Content -->
            <tr>
              <td style="padding:32px; font-size:14px; color:#151416;">
                <p style="font-size:20px; font-weight:bold; margin-top:0;">Hooray, your ticket is confirmed!</p>
                <p style="margin:12px 0 24px;">
                  Hello <strong>{{ $guest_name }}</strong>,<br />
                  Thank you for ordering your ticket to {{ $name }}.
                </p>
                <p>We’ve received your booking and payment! Your ticket for this event has been issued.</p>

                <!-- Order Info -->
                <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; border-radius:8px; padding:24px; margin-bottom:24px;">
                  <tr>
                    <td style="padding:12px;">Order Status</td>
                    <td style="padding:12px;" align="right">
                      <span style="background-color:#e7f9eb; color:#2e8544; border:1px solid #2e8544; border-radius:4px; padding:4px 12px; font-size:12px; font-weight:bold;">
                        {{ $status }}
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:12px;">Order Number</td>
                    <td style="padding:12px;" align="right">{{ $booking_code }}</td>
                  </tr>
                  <tr>
                    <td style="padding:12px;">Order Date</td>
                    <td style="padding:12px;" align="right">{{ $date }}</td>
                  </tr>
                  <tr>
                    <td style="padding:12px;">Payment Method</td>
                    <td style="padding:12px;" align="right">{{ $payment_type }}</td>
                  </tr>
                </table>

                <!-- Button -->
                <p>
                  <a href="#" style="display:block; width:100%; background-color:#0152d0; color:#ffffff; text-align:center; padding:12px 0; border-radius:6px; text-decoration:none; font-weight:bold;">
                    View E-Voucher
                  </a>
                </p>

                <hr style="border:none; border-top:1px solid #dbe0e8; margin:24px 0;" />

                <!-- Destination Info -->
                <p style="font-size:16px; font-weight:bold; margin-bottom:12px;">{{ $name }}</p>
                <table width="100%" style="font-size:14px; color:#151416;">
                  <tr>
                    <td style="padding:8px 0; width:30%; color:#444;">Ticket Date</td>
                    <td style="padding:8px 4px;">:</td>
                    <td style="padding:8px 0;">{{ $checkin }}</td>
                  </tr>
                  @if ($address !== null)
                    <tr>
                        <td style="padding:8px 0; color:#444;">Location</td>
                        <td style="padding:8px 4px;">:</td>
                        <td style="padding:8px 0;">{{ $address }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td style="padding:8px 0; color:#444;">Number of Tickets</td>
                    <td style="padding:8px 4px;">:</td>
                    <td style="padding:8px 0;">
                      {{ $ticket_count }}x Ticket<br />
                      <span style="color:#8e919b;">Total Price: @currency($total_amount)</span>
                    </td>
                  </tr>
                </table>

                <hr style="border:none; border-top:1px solid #dbe0e8; margin:24px 0;" />

                <!-- Order Summary -->
                <p style="font-size:16px; font-weight:bold; margin-bottom:12px;">Order Summary</p>
                <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #dfe3e8; font-size:14px;">
                  <thead style="background-color:#f5f7fa;">
                    <tr>
                      <th align="left" style="padding:12px;">Item</th>
                      <th align="left" style="padding:12px;">Price per Ticket</th>
                      <th align="left" style="padding:12px;">Quantity</th>
                      <th align="right" style="padding:12px;">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($item_details as $item)
                    <tr>
                      <td style="padding:12px;">{{ $item['ticket_name'] }}</td>
                      <td style="padding:12px;">@currency($item['price'])</td>
                      <td style="padding:12px;">{{ $item['quantity'] }}</td>
                      <td style="padding:12px;" align="right">@currency($item['sub_total'])</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="3" style="padding:12px;">
                        Admin Fee & Tax<br />
                        <small>(Non-refundable)</small>
                      </td>
                      <td style="padding:12px;" align="right">@currency($tax)</td>
                    </tr>
                    <tr style="background-color:#f9f9f9;">
                      <td colspan="3" style="padding:16px; font-weight:bold;">Grand Total</td>
                      <td style="padding:16px;" align="right"><strong>@currency($total_amount)</strong></td>
                    </tr>
                  </tbody>
                </table>

                <!-- Footer -->
                <p style="text-align:center; font-size:13px; color:#666; margin-top:32px; padding-bottom:32px;">
                  Thank you for booking with us.
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
