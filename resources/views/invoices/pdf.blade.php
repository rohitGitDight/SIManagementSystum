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
        p { font-size: 16px; margin: 5px 0; }
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
            <div class="separator"></div> <!-- Divider Between Sections -->

            <div class="section-header">Payment Section {{ $index + 1 }}</div>

            <!-- Payment Details Section -->
            <div class="section payment-section">
                <h3>Payment Details</h3>
                <p><strong>User Name:</strong> {{ $invoice->user->name }}</p>
                <p><strong>Course Name:</strong> {{ $invoice->course->name_of_course }}</p>
                <p><strong>Payment Type:</strong> {{ ucfirst($paymentDetails['transaction_type']) }}</p>
                <p><strong>Amount Paid:</strong> {{ number_format((float) $paymentDetails['amount'], 2) }}</p>
            </div>

            <!-- Debited Details Section -->
            <div class="section debit-section">
                <h3>Debited Details</h3>
                <p><strong>Cash Received By:</strong> {{ $paymentDetails['cash_received_by'] ?? 'N/A' }}</p>
                <p><strong>Transaction ID:</strong> {{ $paymentDetails['transaction_id'] ?? 'N/A' }}</p>
                <p><strong>Cheque Number:</strong> {{ $paymentDetails['cheque_number'] ?? 'N/A' }}</p>
                @if(!empty($paymentDetails['transaction_report']) && $paymentDetails['transaction_report'] !== 'N/A')
                    <p><strong>Transaction Report:</strong> 
                        <a href="{{ asset('images/'.$paymentDetails['transaction_report']) }}" target="_blank">View Report</a>
                    </p>
                @endif
            </div>

            <!-- Balance & Dates Section -->
            <div class="section balance-section">
                <h3>Balance & Dates</h3>
                <p><strong>Payment Done Date:</strong> {{ $paymentDetails['payment_done_date'] ?? 'N/A' }}</p>
                <br>
                <p><strong>Pending Amount Of This Transaction:</strong> <span style="color: red;">{{ number_format((float) $paymentDetails['pending_amount'], 2) }}</span></p>
                <p><strong>Remaining Amount:</strong> <span style="color: red;">{{ number_format((float) $paymentDetails['remaining_amount'], 2) }}</span></p>
                <p><strong>Next Payment Date:</strong> {{ $paymentDetails['next_payment_date'] ?? 'N/A' }}</p>
                <p><strong>Next Payment Amount:</strong> 
                    {{ !empty($paymentDetails['next_payment_amount']) ? $paymentDetails['next_payment_amount'] : 'N/A' }}
                </p>
            </div>
        @endforeach

        <div class="footer">
            <p>Thank you for your payment! If you have any questions, contact support.</p>
        </div>
    </div>
</body>
</html>
