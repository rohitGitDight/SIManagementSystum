@php
    // Ensure it's a string before decoding
    $paymentDetailsArray = is_string($paymentDetails) ? json_decode($paymentDetails, true) : $paymentDetails;
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .invoice-container { background: #fff; padding: 20px; border-radius: 8px; max-width: 700px; margin: auto; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .invoice-header { text-align: center; margin-bottom: 20px; }
        .invoice-header img { max-width: 100px; margin-bottom: 10px; }
        .invoice-title { font-size: 24px; font-weight: bold; color: #333; }
        .section { margin-bottom: 20px; padding: 15px; border-radius: 5px; border: 1px solid #ccc; }
        .payment-section { background: #e3f2fd; }
        .debit-section { background: #fbe9e7; }
        .balance-section { background: #e8f5e9; }
        .section-header { font-size: 20px; font-weight: bold; margin-bottom: 10px; text-align: center; }
        .separator { margin: 30px 0; border-top: 2px dashed #ccc; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .footer { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <img src="{{ public_path('images/logo.png') }}" alt="Company Logo">
            <p class="invoice-title">Invoice</p>
        </div>

        @foreach($paymentDetailsArray as $index => $paymentDetails)
            <div class="separator"></div>
            <div class="section-header">Payment {{ $index + 1 }}</div>

            <div class="section payment-section">
                <h3>Payment Details</h3>
                <table>
                    <tr><th>User Name</th><td>{{ $invoice->user->name }}</td></tr>
                    <tr><th>Course Name</th><td>{{ $invoice->course->name_of_course }}</td></tr>
                    <tr><th>Payment Type</th><td>{{ ucfirst($paymentDetails['transaction_type']) }}</td></tr>
                    <tr><th>Amount Paid</th><td>{{ number_format((float) $paymentDetails['amount'], 2) }}</td></tr>
                </table>
            </div>

            <div class="section debit-section">
                <h3>Debited Details</h3>
                <table>
                    <tr><th>Cash Received By</th><td>{{ $paymentDetails['cash_received_by'] ?? 'N/A' }}</td></tr>
                    <tr><th>Transaction ID</th><td>{{ $paymentDetails['transaction_id'] ?? 'N/A' }}</td></tr>
                    <tr><th>Cheque Number</th><td>{{ $paymentDetails['cheque_number'] ?? 'N/A' }}</td></tr>
                    @if(!empty($paymentDetails['transaction_report']) && $paymentDetails['transaction_report'] !== 'N/A')
                        <tr><th>Transaction Report</th>
                            <td><a href="{{ asset('images/'.$paymentDetails['transaction_report']) }}" target="_blank">View Report</a></td>
                        </tr>
                    @endif
                </table>
            </div>

            <div class="section balance-section">
                <h3>Balance & Dates</h3>
                <table>
                    <tr><th>Payment Done Date</th><td>{{ $paymentDetails['payment_done_date'] ?? 'N/A' }}</td></tr>
                    <tr><th>Pending Amount Of This Transaction</th><td style="color: red;">{{ number_format((float) $paymentDetails['pending_amount'], 2) }}</td></tr>
                    <tr><th>Remaining Amount</th><td style="color: red;">{{ number_format((float) $paymentDetails['remaining_amount'], 2) }}</td></tr>
                    <tr><th>Next Payment Date</th><td>{{ $paymentDetails['next_payment_date'] ?? 'N/A' }}</td></tr>
                    <tr><th>Next Payment Amount</th><td>{{ !empty($paymentDetails['next_payment_amount']) ? $paymentDetails['next_payment_amount'] : 'N/A' }}</td></tr>
                </table>
            </div>
        @endforeach

        <div class="footer">
            <p>Thank you for your payment! If you have any questions, contact support.</p>
        </div>
    </div>
</body>
</html>