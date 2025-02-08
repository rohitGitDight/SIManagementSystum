@extends('layouts.app')
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
@section('content')
<div class="container">
    <h2>Edit Fee Transaction</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student_fee_transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Hidden Inputs for User ID, Course ID, and Payment Type -->
        <input type="hidden" name="payment_type" value="{{ $transaction->payment_type }}">
        <input type="hidden" name="transaction_amount" value="{{ $transaction->amount }}">
    
        <div class="form-group">
            <label for="user_id">Student</label>
            <select name="user_id_disabled" class="form-control" disabled>
                <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}"
                        {{ ($transaction->user_id == $student->id) ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="user_id" value="{{ $transaction->user_id }}">
        </div>

        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id_disabled" class="form-control" disabled>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" 
                        {{ ($transaction->course_id == $course->id) ? 'selected' : '' }}>
                        {{ $course->name_of_course }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="course_id" value="{{ $transaction->course_id }}">
        </div>

        {{-- <div class="form-group">
            <label for="transaction_type">Transaction Type</label>
            <select name="transaction_type" class="form-control" id="transaction_type" required>
                <option value="Cheque" {{ $transaction->transaction_type == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="Cash" {{ $transaction->transaction_type == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Paytm" {{ $transaction->transaction_type == 'Paytm' ? 'selected' : '' }}>Paytm</option>
                <option value="Google Pay" {{ $transaction->transaction_type == 'Google Pay' ? 'selected' : '' }}>Google Pay</option>
                <option value="RTGS" {{ $transaction->transaction_type == 'RTGS' ? 'selected' : '' }}>RTGS</option>
                <option value="Bank Transfer" {{ $transaction->transaction_type == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
            </select>
        </div> --}}

        {{-- <div class="form-group" id="transaction_id_div">
            <label for="transaction_id">Transaction ID (if applicable)</label>
            <input type="text" name="transaction_id" class="form-control" value="{{ $transaction->transaction_id }}">
        </div> --}}

        {{-- <div class="form-group" id="cheque_number_div" style="display: none;">
            <label for="cheque_number">Cheque Number</label>
            <input type="text" name="cheque_number" class="form-control" value="{{ $transaction->cheque_number }}">
        </div>

        <div class="form-group" id="cash_received_by_div" style="display: none;">
            <label for="cash_received_by">Cash Received By</label>
            <input type="text" name="cash_received_by" class="form-control" value="{{ $transaction->cash_received_by }}">
        </div>

        <div class="form-group" id="payment_done_date_div" style="display: none;">
            <label for="payment_done_date">Payment Done Date</label>
            <input type="date" name="payment_done_date" class="form-control" value="{{ $transaction->payment_done_date ?? old('payment_done_date') }}">
        </div>
        
        <div class="form-group" id="transaction_report_div">
            <label for="transaction_report">Upload Transaction Report</label>
            <input type="file" name="transaction_report" class="form-control" accept="image/*">
        </div> --}}

        <div class="form-group">
            <label for="amount">Amount Paid</label>
            @php
                $transactionRemaing = \App\Models\StudentCourseFee::where([
                    'user_id' => $transaction->user_id,
                    'course_id' => $transaction->course_id
                ])->first();
            @endphp
            <input type="number" name="amount" id="amount" class="form-control" 
                value="{{ $transaction->amount }}" 
                max="{{ $transaction->payment_type_target }}" 
                step="0.01"
                oninput="checkAmount()" required>
            
            <span id="error-message" class="text-danger" style="display:none;">
                Maximum allowed: ₹{{ number_format($transactionRemaing->remaining_amount, 2) }}
            </span>
        </div>
        

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {
        function updateFields() {
            var selectedValue = $('#transaction_type').val();

            $('#transaction_id_div, #cheque_number_div, #cash_received_by_div, #transaction_report_div').hide();
            $('#transaction_id, #cheque_number, #cash_received_by, #transaction_report').prop('required', false);

            if (selectedValue === 'Cheque') {
                $('#cheque_number_div, #transaction_report_div').show();
                $('#cheque_number, #transaction_report').prop('required', true);
            } else if (selectedValue === 'Cash') {
                $('#cash_received_by_div').show();
                $('#cash_received_by').prop('required', true);
            } else if (['Paytm', 'Google Pay', 'RTGS', 'Bank Transfer'].includes(selectedValue)) {
                $('#transaction_id_div, #transaction_report_div').show();
                $('#transaction_id, #transaction_report').prop('required', true);
            }
        }

        $('#transaction_type').on('change', updateFields);
        updateFields();
    });

    function checkAmount() {
        const amountField = document.getElementById('amount');
        const errorMessage = document.getElementById('error-message');
        
        if (!amountField) return;

        const maxAmount = parseFloat(amountField.max) || 0; 
        let enteredAmount = parseFloat(amountField.value) || 0;

        // Check if entered amount exceeds the limit
        if (enteredAmount > maxAmount) {
            errorMessage.style.display = 'inline';  // Show the error message
            errorMessage.textContent = `Amount cannot exceed ₹${maxAmount.toFixed(2)}`; // Show message
            amountField.value = maxAmount.toFixed(2); // Auto-correct the value
        } else {
            errorMessage.style.display = 'none';   // Hide the error message if the value is valid
        }

        // Prevent negative values
        if (enteredAmount < 0) {
            amountField.value = '0.00';
        }
    }


</script>

@endsection
