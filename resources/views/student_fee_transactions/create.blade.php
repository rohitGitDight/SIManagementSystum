@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Fee Transaction</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student_fee_transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="user_id">Student</label>
            <?php //echo "<pre>"; print_r($students->image);die;?>
            <select name="user_id" class="form-control" required>
                @foreach($students as $student) 
                    <option value="{{ $student->id }}">
                        <!-- Display the student image -->
                        @if ($students->image)
                            <img src="{{ url('transaction_reports/' . $students->image) }}" alt="{{ $student->name }}" width="30" height="30" style="border-radius: 50%; margin-right: 10px;">
                        @else
                            <span>No image</span>
                        @endif
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            
        </div>
        
        {{-- <div class="form-group">
            <label for="user_id">Student</label>
            <select name="user_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" class="form-control" required>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name_of_course }}</option>
                @endforeach
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    document.getElementById('transaction_type').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('cheque_number_div').style.display = selectedValue === 'Cheque' ? 'block' : 'none';
        document.getElementById('cash_received_by_div').style.display = selectedValue === 'Cash' ? 'block' : 'none';
        document.getElementById('transaction_report_div').style.display = selectedValue !== 'Cash' ? 'block' : 'none';
    });

    document.getElementById('transaction_type').dispatchEvent(new Event('change'));

</script>

@endsection
