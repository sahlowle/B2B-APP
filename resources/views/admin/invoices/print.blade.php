<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .customer-info {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #333;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            border-top: 2px solid #333;
            padding-top: 20px;
        }
        @media print {
            body { margin: 0; padding: 15px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>#{{ $invoice->invoice_number }}</h2>
    </div>

    <div class="invoice-details">
        <table style="border: none;">
            <tr>
                <td style="border: none; width: 50%;">
                    <strong>Invoice #:</strong> {{ $invoice->invoice_number }}
                </td>
                <td style="border: none; width: 50%; text-align: right;">
                    <strong>Currency:</strong> {{ $invoice->currency }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Currency</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->currency }}</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @if($invoice->notes)
        <div class="notes">
            <h3>Notes:</h3>
            <p>{{ $invoice->notes }}</p>
        </div>
    @endif

    @if($invoice->terms_conditions)
        <div class="terms">
            <h3>Terms & Conditions:</h3>
            <p>{{ $invoice->terms_conditions }}</p>
        </div>
    @endif

    <div class="footer">
        <p><em>Thank you for your business!</em></p>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
    </div>
</body>
</html>
