<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>New Inquiry</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f3f4f6;padding:24px 0;">
  <tr>
    <td align="center" style="padding:0 16px;">
      <table role="presentation" cellpadding="0" cellspacing="0" width="680" style="max-width:680px;width:100%;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 12px 36px rgba(15,23,42,0.18);">
        <tr>
          <td style="background:#DA2B28;padding:18px 22px;">
            <div style="font-family:Arial,Helvetica,sans-serif;color:#ffffff;font-size:16px;font-weight:700;letter-spacing:0.6px;">LEAVE A MESSAGE</div>
            <div style="font-family:Arial,Helvetica,sans-serif;color:rgba(255,255,255,0.9);font-size:12px;margin-top:6px;">A new inquiry has been received on your website.</div>
          </td>
        </tr>

        <tr>
          <td style="padding:18px 22px 6px;">
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;border-spacing:0 10px;">
              <tr>
                <td style="width:140px;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;">Inquiry ID</td>
                <td style="font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;font-weight:700;">{{ $inquiry->id }}</td>
              </tr>
              <tr>
                <td style="width:140px;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;">Created At</td>
                <td style="font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;">{{ $inquiry->created_at }}</td>
              </tr>
              <tr>
                <td style="width:140px;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;">Client</td>
                <td style="font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;">{{ $inquiry->client }}</td>
              </tr>
              <tr>
                <td style="width:140px;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;">Source URL</td>
                <td style="font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;word-break:break-all;">
                  @if(!empty($inquiry->source_url))
                    <a href="{{ $inquiry->source_url }}" style="color:#DA2B28;text-decoration:none;">{{ $inquiry->source_url }}</a>
                  @else
                    -
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width:140px;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;">IP / Location</td>
                <td style="font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;">{{ $inquiry->ip }}@if(!empty($inquiry->location)) ({{ $inquiry->location }})@endif</td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td style="padding:0 22px 6px;">
            <div style="font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0f172a;margin:10px 0 8px;">Contact Details</div>
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
              <tr>
                <td style="padding:10px 12px;border-bottom:1px solid #e5e7eb;background:#fafafa;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;width:140px;">Email</td>
                <td style="padding:10px 12px;border-bottom:1px solid #e5e7eb;font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;">
                  <a href="mailto:{{ $inquiry->email }}" style="color:#0f172a;text-decoration:none;">{{ $inquiry->email }}</a>
                </td>
              </tr>
              <tr>
                <td style="padding:10px 12px;background:#fafafa;font-family:Arial,Helvetica,sans-serif;color:#64748b;font-size:12px;width:140px;">Tel/WhatsApp</td>
                <td style="padding:10px 12px;font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;">
                  @if(!empty($inquiry->tel))
                    <a href="tel:{{ $inquiry->tel }}" style="color:#0f172a;text-decoration:none;">{{ $inquiry->tel }}</a>
                  @else
                    -
                  @endif
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td style="padding:0 22px 10px;">
            <div style="font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0f172a;margin:10px 0 8px;">Inquiry Message</div>
            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:12px;background:#ffffff;font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;line-height:1.7;white-space:pre-wrap;word-break:break-word;">{{ $inquiry->content }}</div>
          </td>
        </tr>

        @if(isset($products) && count($products))
        <tr>
          <td style="padding:0 22px 14px;">
            <div style="font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0f172a;margin:10px 0 8px;">Related Products</div>
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
              <tr>
                <td style="padding:10px 12px;background:#fafafa;border-bottom:1px solid #e5e7eb;font-family:Arial,Helvetica,sans-serif;color:#475569;font-size:12px;font-weight:700;">Product</td>
                <td style="padding:10px 12px;background:#fafafa;border-bottom:1px solid #e5e7eb;font-family:Arial,Helvetica,sans-serif;color:#475569;font-size:12px;font-weight:700;width:90px;text-align:right;">Qty</td>
              </tr>
              @foreach($products as $p)
              <tr>
                <td style="padding:10px 12px;border-bottom:1px solid #f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;">{{ $p['name'] }}</td>
                <td style="padding:10px 12px;border-bottom:1px solid #f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#0f172a;font-size:12px;text-align:right;">{{ $p['quantity'] }}</td>
              </tr>
              @endforeach
            </table>
          </td>
        </tr>
        @endif

        <tr>
          <td style="padding:14px 22px 18px;background:#0b1220;">
            <div style="font-family:Arial,Helvetica,sans-serif;color:rgba(255,255,255,0.92);font-size:12px;line-height:1.6;">
              This is an automated notification from your website inquiry system.
            </div>
            <div style="font-family:Arial,Helvetica,sans-serif;color:rgba(255,255,255,0.65);font-size:11px;margin-top:6px;">Please do not reply to this email directly.</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
