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
                    <strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}<br>
                    <strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}<br>
                    <strong>Status:</strong> {{ ucfirst($invoice->status) }}
                </td>
                <td style="border: none; width: 50%; text-align: right;">
                    <strong>Currency:</strong> {{ $invoice->currency }}
                </td>
            </tr>
        </table>
    </div>

    <div class="customer-info">
        <h3>Bill To:</h3>
        <p>
            <strong>{{ $invoice->customer_name }}</strong><br>
            {{ $invoice->customer_email }}<br>
            @if($invoice->customer_phone)
                {{ $invoice->customer_phone }}<br>
            @endif
            @if($invoice->customer_address)
                {{ $invoice->customer_address }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ $invoice->currency }} {{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right"><strong>{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</strong></td>
            </tr>
            @if($invoice->tax_amount > 0)
                <tr>
                    <td colspan="3" class="text-right"><strong>Tax ({{ $invoice->tax_rate }}%):</strong></td>
                    <td class="text-right"><strong>{{ $invoice->currency }} {{ number_format($invoice->tax_amount, 2) }}</strong></td>
                </tr>
            @endif
            @if($invoice->discount_amount > 0)
                <tr>
                    <td colspan="3" class="text-right"><strong>Discount:</strong></td>
                    <td class="text-right"><strong>-{{ $invoice->currency }} {{ number_format($invoice->discount_amount, 2) }}</strong></td>
                </tr>
            @endif
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</strong></td>
            </tr>
        </tfoot>
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
</body>
</html>
