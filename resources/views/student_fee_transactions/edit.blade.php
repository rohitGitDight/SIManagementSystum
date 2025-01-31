@extends('layouts.app')

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

        <div class="form-group">
            <label for="transaction_type">Transaction Type</label>
            <select name="transaction_type" class="form-control" id="transaction_type" required>
                <option value="Cheque" {{ $transaction->transaction_type == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="Cash" {{ $transaction->transaction_type == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Paytm" {{ $transaction->transaction_type == 'Paytm' ? 'selected' : '' }}>Paytm</option>
                <option value="Google Pay" {{ $transaction->transaction_type == 'Google Pay' ? 'selected' : '' }}>Google Pay</option>
                <option value="RTGS" {{ $transaction->transaction_type == 'RTGS' ? 'selected' : '' }}>RTGS</option>
                <option value="Bank Transfer" {{ $transaction->transaction_type == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
            </select>
        </div>

        <div class="form-group" id="transaction_id_div">
            <label for="transaction_id">Transaction ID (if applicable)</label>
            <input type="text" name="transaction_id" class="form-control" value="{{ $transaction->transaction_id }}">
        </div>

        <div class="form-group" id="cheque_number_div" style="display: none;">
            <label for="cheque_number">Cheque Number</label>
            <input type="text" name="cheque_number" class="form-control" value="{{ $transaction->cheque_number }}">
        </div>

        <div class="form-group" id="cash_received_by_div" style="display: none;">
            <label for="cash_received_by">Cash Received By</label>
            <input type="text" name="cash_received_by" class="form-control" value="{{ $transaction->cash_received_by }}">
        </div>

        <div class="form-group" id="transaction_report_div">
            <label for="transaction_report">Upload Transaction Report</label>
            <input type="file" name="transaction_report" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label for="amount">Amount Paid</label>
            <input type="number" name="amount" class="form-control" value="{{ $transaction->amount }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    $(document).ready(function() {
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
</script>

@endsection
