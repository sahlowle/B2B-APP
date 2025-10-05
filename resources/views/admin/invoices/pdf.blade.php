<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 30px;
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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 20px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
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

    <div class="footer">
        <p><em>Thank you for your business!</em></p>
    </div>
</body>
</html>
