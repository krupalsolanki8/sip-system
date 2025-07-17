<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SIP Cancelled – {{ $app_name }}</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 2rem;">
    <div style="max-width: 600px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #eee; padding: 2rem;">
        <h2 style="color: #dc2626;">Hello, {{ $user_name }}!</h2>
        <p>We wanted to let you know that your SIP has been <strong>cancelled</strong> in <strong>{{ $app_name }}</strong>.</p>
        <h3 style="margin-top: 2rem;">SIP Details:</h3>
        <ul style="line-height: 1.8;">
            <li><strong>Amount:</strong> {{ $sip->amount }}</li>
            <li><strong>Frequency:</strong> {{ ucfirst($sip->frequency) }}</li>
            @if($sip->frequency === 'monthly')
                <li><strong>SIP Day:</strong> {{ $sip->sip_day }}</li>
            @endif
            <li><strong>Start Date:</strong> {{ $sip->start_date }}</li>
            <li><strong>End Date:</strong> {{ $sip->end_date }}</li>
        </ul>
        <p>If you have any questions or believe this was a mistake, please contact our support team.</p>
        <br>
        <p>Thank you for using <strong>{{ $app_name }}</strong>!<br><strong>The {{ $app_name }} Team</strong></p>
    </div>
</body>
</html> 