@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Course Fees</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Course Fee</th>
                <th>Payment Details</th>
                <th>Remaining Amount</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fees as $fee)
                <tr>
                    <td>{{ $fee->user->name ?? 'N/A' }}</td>
                    <td>{{ $fee->course->name_of_course ?? 'N/A' }}</td>
                    <td>{{ $fee->course_fee }}</td>
                    <td>
                        @if ($fee->payment_details)
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Payment</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Action</th> <!-- Added column for button -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($fee->payment_details) as $key => $payment)
                                        <tr>
                                            <td>{{ $payment->payment }} /-</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                                            <td>
                                                @if ($payment->payment_status == 1)
                                                    <span style="color: green; font-weight: bold;">Complete</span>
                                                @else
                                                    <span style="color: red; font-weight: bold;">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($payment->payment_status == 1)
                                                    <i class="fas fa-check-circle" style="color: green;"></i>
                                                @else
                                                    <a href="{{ route('student_fee_transactions.create', ['user_id' => $fee->user->id, 'course_id' => $fee->course->id, 'payment_type' => $key + 1 , 'amount' => $payment->payment]) }}" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            No payment details available
                        @endif
                    </td>
                    <td>{{ $fee->remaining_amount }}</td>
                    <td>{{ $fee->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</div>
@endsection
