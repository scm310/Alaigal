<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoiceNumber }}</title>
    <style>
        /* Base Styles */
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        /* Header with Solid Color (fallback) */
        .header {
            background-color: #DEA193; /* Fallback solid color */
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        
        .header h2, .header h3 {
            margin: 5px 0;
            color: black;
        }
        
        /* Invoice Info */
        .invoice-info {
            text-align: right;
            margin-bottom: 20px;
        }
        
        /* Customer Info */
        .customer-info {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border-radius:5px;
        }
        
        thead th {
            background-color: #EED9C4;
               border-radius:5px;
            padding: 12px;
            text-align: left;
        }
        
        tbody {
            background-color: #e7cfcf;
               border-radius:5px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f0d9d9;
        }
        
        td, th {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        td {
            text-align: left;
        }
        
        /* Total Row */
        .total {
            font-weight: bold;
            background-color: #d9c2c2;
        }
        
        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        /* Currency Formatting */
        .currency {
            font-family: 'DejaVu Sans', Arial, sans-serif;
        }
    </style>
</head>
<body>
    <!-- Header with Gradient -->
    <div class="header">
        <h2>TIEPMD</h2>
        <h3>Subscription Invoice</h3>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-info">
        <p><strong>Invoice #:</strong> {{ $invoiceNumber }}</p>
        <p><strong>Date:</strong> {{ now()->format('d M, Y') }}</p>
    </div>

    <!-- Customer Info -->
    <div class="customer-info">
        <h3>Bill To:</h3>
        <p>{{ $member->first_name }} {{ $member->last_name }}</p>
        <p>{{ $member->email }}</p>
        <p>{{ $member->phone_number }}</p>
    </div>

    <!-- Invoice Table -->
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ ucfirst(str_replace('_', ' ', $subscription->plan_type)) }} Subscription</td>
                <td class="currency">₹{{ number_format($subscription->amount, 2) }}</td>
            </tr>
            <tr>
                <td>CGST (9%)</td>
                <td class="currency">₹{{ number_format($subscription->amount * 0.09, 2) }}</td>
            </tr>
            <tr>
                <td>SGST (9%)</td>
                <td class="currency">₹{{ number_format($subscription->amount * 0.09, 2) }}</td>
            </tr>
            <tr class="total">
                <td>Total Payable</td>
                <td class="currency">₹{{ number_format($subscription->amount * 1.18, 2) }}</td>
            </tr>
            <tr>
                <td>Payment ID</td>
                <td>{{ $subscription->order_id }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your subscription!</p>
        <p>TIEPMD - Tamil Nadu Interior Exterior Product Merchant Directory</p>
    </div>
</body>
</html>