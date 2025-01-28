@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Transaction Details</h2>

        <a href="{{ route('fee_transactions.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transaction #{{ $transaction->id }}</h5>

                <table class="table table-bordered">
                    <tr>
                        <th>Student ID</th>
                        <td>{{ $transaction->student_id }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Type</th>
                        <td>{{ $transaction->transaction_type }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{ $transaction->amount }}</td>
                    </tr>
                    <tr>
                        <th>Payment Date</th>
                        <td>
                            @if($transaction->payment_date instanceof \Carbon\Carbon)
                                {{ $transaction->payment_date->format('d-m-Y') }}
                            @else
                                {{ $transaction->payment_date }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Cheque Number</th>
                        <td>{{ $transaction->cheque_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cash Received By</th>
                        <td>{{ $transaction->cash_received_by ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Report</th>
                        <td>
                            @if($transaction->transaction_report)
                                <a href="{{ asset('storage/' . $transaction->transaction_report) }}" target="_blank">View Report</a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge badge-success">Paid</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
