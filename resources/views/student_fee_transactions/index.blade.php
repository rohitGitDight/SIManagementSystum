@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Fee Transactions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('student_fee_transactions.create') }}" class="btn btn-primary mb-3">Add New Transaction</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Transaction Type</th>
                <th>Transaction ID</th>
                <th>Cheque Number</th>
                <th>Cash Received By</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Transaction Report</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->student->name }}</td>
                    <td>{{ $transaction->course->name_of_course }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->transaction_id ?? '-' }}</td>
                    <td>{{ $transaction->cheque_number ?? '-' }}</td>
                    <td>{{ $transaction->cash_received_by ?? '-' }}</td>
                    <td>₹{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->payment_date }}</td>
                    <td>
                        @if($transaction->transaction_report)
                            <a href="{{ asset('images/' . $transaction->transaction_report) }}" target="_blank">View Report</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection