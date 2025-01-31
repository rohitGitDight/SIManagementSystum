@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Fee Transactions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Payment Type</th>
                <th>Transaction Type</th>
                <th>Transaction ID</th>
                <th>Cheque Number</th>
                <th>Cash Received By</th>
                <th>Amount</th>
                <th>Transaction Report</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
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
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->student->name }}</td>
                    <td>{{ $transaction->course->name_of_course }}</td>
                    <td>{{ $transaction->payment_type ? getOrdinal($transaction->payment_type) : '-' }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->transaction_id ?? '-' }}</td>
                    <td>{{ $transaction->cheque_number ?? '-' }}</td>
                    <td>{{ $transaction->cash_received_by ?? '-' }}</td>
                    <td>₹{{ number_format($transaction->amount, 2) }}</td>
                    <td>
                        @if($transaction->transaction_report)
                        <a href="{{ asset('images/' . $transaction->transaction_report) }}" target="_blank">View Report</a>
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $transaction->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection