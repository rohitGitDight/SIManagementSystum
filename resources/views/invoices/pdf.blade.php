@php
    // Ensure it's a string before decoding
    $paymentDetailsArray = is_string($paymentDetails) ? json_decode($paymentDetails, true) : $paymentDetails;
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 10px; background: #f5f5f5; }
        .invoice-container { background: #fff; padding: 20px; border-radius: 8px; max-width: 850px; margin: auto; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); border: 1px solid #2c3e50; }
        .invoice-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #2c3e50; padding-bottom: 5px; }
        .invoice-header img { max-width: 60px; }
        .invoice-title { font-size: 20px; font-weight: bold; color: #2c3e50; text-transform: uppercase; }
        .table-container { margin-top: 15px; border-top: 1px solid #2c3e50; padding-top: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; table-layout: fixed; }
        table, th, td { border: 1px solid #2c3e50; padding: 5px; text-align: center; word-wrap: break-word; }
        th { background: #2c3e50; color: #fff; text-transform: uppercase; font-size: 8px; }
        td { font-size: 8px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #666; border-top: 1px solid #2c3e50; padding-top: 5px; }
        .red-text { color: red; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="invoice-title">INVOICE</div>
            <img src="{{ public_path('images/logo.png') }}" alt="Company Logo">
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <th>User</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Paid</th>
                    <th>Received By</th>
                    <th>Transaction ID</th>
                    <th>Cheque No.</th>
                    <th>Report</th>
                    <th>Date</th>
                    <th class="red-text">Pending</th>
                    <th class="red-text">Remaining</th>
                    <th>Next Date</th>
                    <th>Next Amount</th>
                </tr>
                
                @foreach($paymentDetailsArray as $paymentDetails)
                <tr>
                    <td>{{ $invoice->user->name }}</td>
                    <td>{{ $invoice->course->name_of_course }}</td>
                    <td>{{ ucfirst($paymentDetails['transaction_type']) }}</td>
                    <td>${{ number_format((float) $paymentDetails['amount'], 2) }}</td>
                    <td>{{ $paymentDetails['cash_received_by'] ?? 'N/A' }}</td>
                    <td>{{ $paymentDetails['transaction_id'] ?? 'N/A' }}</td>
                    <td>{{ $paymentDetails['cheque_number'] ?? 'N/A' }}</td>
                    <td>
                        @if(!empty($paymentDetails['transaction_report']) && $paymentDetails['transaction_report'] !== 'N/A')
                            <a href="{{ asset('images/'.$paymentDetails['transaction_report']) }}" target="_blank">View</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $paymentDetails['payment_done_date'] ?? 'N/A' }}</td>
                    <td class="red-text">${{ number_format((float) $paymentDetails['pending_amount'], 2) }}</td>
                    <td class="red-text">${{ number_format((float) $paymentDetails['remaining_amount'], 2) }}</td>
                    <td>{{ $paymentDetails['next_payment_date'] ?? 'N/A' }}</td>
                    <td>${{ $paymentDetails['next_payment_amount'] ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="footer">
            Thank you for your business!
        </div>
    </div>
</body>
</html>
