@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Course Fee Details</h1>

        <div class="card">
            <div class="card-header">
                Course Fee for: {{ $fee->user->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Course: {{ $fee->course->name }}</h5>
                <p><strong>Fee Amount:</strong> ₹{{ number_format($fee->remaining_amount, 2) }}</p>

                <h6 class="mt-3"><strong>Payment Details:</strong></h6>

                <!-- Payment Details Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Payment Date</th>
                            <th scope="col">Amount Paid</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (json_decode($fee->payment_details, true) as $key => $payment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($payment['payment_date'])->format('d-m-Y') }}</td>
                                <td>₹{{ number_format($payment['payment'], 2) }}</td>
                                <td>
                                    @if ($payment['payment_status'] == 0)
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-success">Paid</span>
                                    @endif
                                </td>

                                <td>
                                    @if($payment['payment'] > 0)    
                                        <a href="{{ route('student_fee_transactions.create', [
                                                'user_id' => $fee->user->id, 
                                                'course_id' => $fee->course->id, 
                                                'payment_type' => $key + 1, 
                                                'amount' => $payment['payment'], 
                                                'remaining_amount' => $fee->remaining_amount, 
                                                'payment_date' => $payment['payment_date']
                                            ]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>    
                                    @else
                                        <span style="color: green; font-weight: bold;">Complete <i class="fas fa-check-circle" style="color: green;"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <a href="{{ route('student_course_fees.calendar') }}" class="btn btn-primary mt-3">Back to Calendar</a>
            </div>
        </div>
    </div>
@endsection

