@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Fee Transaction</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('fee_transactions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="transaction_type">Transaction Type</label>
                <select name="transaction_type" class="form-control" id="transaction_type" required>
                    <option value="Cheque">Cheque</option>
                    <option value="Cash">Cash</option>
                    <option value="Paytm">Paytm</option>
                    <option value="Google Pay">Google Pay</option>
                    <option value="RTNS">RTNS</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <!-- Transaction ID (common field, hidden for Cheque and Cash) -->
            <div class="form-group" id="transaction_id_div">
                <label for="transaction_id">Transaction ID (if applicable)</label>
                <input type="text" name="transaction_id" class="form-control">
            </div>

            <!-- Cheque Number (only for Cheque) -->
            <div class="form-group" id="cheque_number_div" style="display: none;">
                <label for="cheque_number">Cheque Number (if applicable)</label>
                <input type="text" name="cheque_number" class="form-control">
            </div>

            <!-- Cash Received By (only for Cash) -->
            <div class="form-group" id="cash_received_by_div" style="display: none;">
                <label for="cash_received_by">Cash Received By (if applicable)</label>
                <input type="text" name="cash_received_by" class="form-control">
            </div>

            <!-- Upload Transaction Report (hidden for Cash) -->
            <div class="form-group" id="transaction_report_div">
                <label for="transaction_report">Upload Transaction Report</label>
                <input type="file" name="transaction_report" class="form-control" accept="image/*">
            </div>
            

            <div class="form-group">
                <label for="amount">Amount Paid</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="payment_date">Payment Date</label>
                <input type="date" name="payment_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        // Handle the transaction type change
        document.getElementById('transaction_type').addEventListener('change', function() {
            var selectedValue = this.value;

            // Hide all conditional fields first
            document.getElementById('cheque_number_div').style.display = 'none';
            document.getElementById('cash_received_by_div').style.display = 'none';
            document.getElementById('transaction_report_div').style.display = 'block'; // Always show upload field

            // Hide Transaction ID for Cheque and Cash
            document.getElementById('transaction_id_div').style.display = 'block'; // Default state for other types
            if (selectedValue === 'Cheque') {
                document.getElementById('transaction_id_div').style.display = 'none'; // Hide for Cheque
                document.getElementById('cheque_number_div').style.display = 'block';  // Show Cheque Number field
            } else if (selectedValue === 'Cash') {
                document.getElementById('transaction_id_div').style.display = 'none'; // Hide for Cash
                document.getElementById('transaction_report_div').style.display = 'none'; // Hide transaction report for Cash
                document.getElementById('cash_received_by_div').style.display = 'block';  // Show Cash Received By field
            }
        });

        // Trigger the change event on page load to handle initial selection
        document.getElementById('transaction_type').dispatchEvent(new Event('change'));
    </script>
@endsection
