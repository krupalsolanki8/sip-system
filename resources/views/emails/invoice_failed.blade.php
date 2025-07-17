<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Failed – {{ $app_name }}</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 2rem;">
    <div style="max-width: 600px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #eee; padding: 2rem;">
        <h2 style="color: #dc2626;">Hello, {{ $user_name }}!</h2>
        <p>We regret to inform you that your SIP payment has <strong>failed</strong> in <strong>{{ $app_name }}</strong>.</p>
        <h3 style="margin-top: 2rem;">Invoice Details:</h3>
        <ul style="line-height: 1.8;">
            <li><strong>Invoice ID:</strong> {{ $invoice->id }}</li>
            <li><strong>Amount:</strong> {{ $invoice->amount }}</li>
            <li><strong>Status:</strong> {{ ucfirst($invoice->status) }}</li>
            <li><strong>Scheduled Date:</strong> {{ $invoice->scheduled_date->toDateString() }}</li>
        </ul>
        <p>Please check your payment method or contact our support team for assistance.</p>
        <br>
        <p>Thank you for using <strong>{{ $app_name }}</strong>!<br><strong>The {{ $app_name }} Team</strong></p>
    </div>
</body>
</html> 