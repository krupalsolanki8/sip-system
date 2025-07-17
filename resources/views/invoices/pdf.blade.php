<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }} – {{ $app_name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; }
        .header { text-align: center; margin-bottom: 2rem; }
        .details { margin-bottom: 2rem; }
        .details th, .details td { padding: 0.5rem 1rem; text-align: left; }
        .footer { margin-top: 2rem; text-align: center; font-size: 0.9rem; color: #888; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .table th, .table td { border: 1px solid #ddd; padding: 0.75rem; }
        .table th { background: #f3f4f6; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $app_name }}</h1>
        <h2>Invoice #{{ $invoice->id }}</h2>
    </div>
    <div class="details">
        <table>
            <tr>
                <th>User:</th>
                <td>{{ $user->name }} ({{ $user->email }})</td>
            </tr>
            <tr>
                <th>Invoice Date:</th>
                <td>{{ \Carbon\Carbon::parse($invoice->scheduled_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>{{ ucfirst($invoice->status) }}</td>
            </tr>
        </table>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">SIP Payment</td>
                <td style="text-align: center;">{{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>{{ number_format($invoice->amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="footer">
        <p>Thank you for your payment!<br>{{ $app_name }}</p>
    </div>
</body>
</html> 