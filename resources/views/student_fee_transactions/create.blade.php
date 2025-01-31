@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Fee Transaction</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student_fee_transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hidden Inputs for User ID, Course ID, and Payment Type -->
        <input type="hidden" name="payment_type" value="{{ request('payment_type') }}">
        @php
            // Helper function to get the English ordinal representation
            function getOrdinal($number) {
                $suffixes = ['st', 'nd', 'rd', 'th'];
                $value = (int) abs($number);
                $mod = $value % 10;
                $suffix = ($mod >= 1 && $mod <= 3 && !in_array($value % 100, [11, 12, 13])) ? $suffixes[$mod - 1] : $suffixes[3];
                return $value . $suffix;
            }
        @endphp
    
        <div class="form-group">
            <label for="user_id">Student</label>
            <select name="user_id_disabled" class="form-control" disabled>
                <option value="">Select Student</option>
                @foreach($students as $student) 
                    <option value="{{ $student->id }}" 
                        {{ (request('user_id') == $student->id) ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <!-- Hidden field to ensure the user_id is submitted -->
            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
        </div>        

        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id_disabled" class="form-control" disabled>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" 
                        {{ (request('course_id') == $course->id) ? 'selected' : '' }}>
                        {{ $course->name_of_course }}
                    </option>
                @endforeach
            </select>
            <!-- Hidden field to ensure the course_id is submitted -->
            <input type="hidden" name="course_id" value="{{ request('course_id') }}">
        </div>
        
        <div class="form-group">
            <label for="payment_type">Payment Type</label>
            <select name="payment_type" class="form-control" id="payment_type" disabled>
                <option value="{{ request('payment_type') }}" 
                    {{ (request('payment_type')) ? 'selected' : '' }}>
                    {{ getOrdinal(request('payment_type')) }} <!-- Dynamically display First, Second, etc. -->
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="transaction_type">Transaction Type</label>
            <select name="transaction_type" class="form-control" id="transaction_type" required>
                <option value="Cheque">Cheque</option>
                <option value="Cash">Cash</option>
                <option value="Paytm">Paytm</option>
                <option value="Google Pay">Google Pay</option>
                <option value="RTGS">RTGS</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>

        <div class="form-group" id="transaction_id_div">
            <label for="transaction_id">Transaction ID (if applicable)</label>
            <input type="text" name="transaction_id" class="form-control">
        </div>

        <div class="form-group" id="cheque_number_div" style="display: none;">
            <label for="cheque_number">Cheque Number</label>
            <input type="text" name="cheque_number" class="form-control">
        </div>

        <div class="form-group" id="cash_received_by_div" style="display: none;">
            <label for="cash_received_by">Cash Received By</label>
            <input type="text" name="cash_received_by" class="form-control">
        </div>

        <div class="form-group" id="transaction_report_div">
            <label for="transaction_report">Upload Transaction Report</label>
            <input type="file" name="transaction_report" class="form-control" accept="image/*">
        </div>
        
        <div class="form-group">
            <label for="amount">Amount Paid - <b style="color:red"> ₹{{ request('amount') }}</b></label>
            <input type="number" name="amount" class="form-control" value="{{ request('amount') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        function updateFields() {
            var selectedValue = $('#transaction_type').val();

            // Hide all fields by default
            $('#transaction_id_div, #cheque_number_div, #cash_received_by_div, #transaction_report_div').hide();
            $('#transaction_id, #cheque_number, #cash_received_by, #transaction_report').prop('required', false);

            // Show fields based on selection
            if (selectedValue === 'Cheque') {
                $('#cheque_number_div, #transaction_report_div').show();
                $('#cheque_number, #transaction_report').prop('required', true);
            } else if (selectedValue === 'Cash') {
                $('#cash_received_by_div').show();
                $('#cash_received_by').prop('required', true);
            } else if (selectedValue === 'Paytm' || selectedValue === 'Google Pay' || selectedValue === 'RTGS' || selectedValue === 'Bank Transfer') {
                $('#transaction_id_div, #transaction_report_div').show();
                $('#transaction_id, #transaction_report').prop('required', true);
            }
        }

        // Run function on change and on page load
        $('#transaction_type').on('change', updateFields);
        updateFields(); // Run on page load

        // Initialize Select2 for better dropdown UX
        $('select').select2();
    });
</script>

@endsection
