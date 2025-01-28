@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Fee Transaction Management</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('fee_transactions.create') }}" class="btn btn-primary mb-3">Add Fee Transaction</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feeTransactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->student_id }}</td>
                        <td>{{ $transaction->transaction_type }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>
                            {{-- Check if payment_date is a Carbon instance before formatting --}}
                            @if($transaction->payment_date instanceof \Carbon\Carbon)
                                {{ $transaction->payment_date->format('d-m-Y') }}
                            @else
                                {{ $transaction->payment_date }} {{-- Fallback if not a Carbon instance --}}
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-success">Paid</span>
                        </td>
                        <td>
                            <a href="{{ route('fee_transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('fee_transactions.destroy', $transaction->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No fee transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
