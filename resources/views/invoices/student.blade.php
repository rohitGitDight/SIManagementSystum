@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Invoices</h1>

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Course</th>
                <th>Payment</th>
                <th>Amount</th>
                <th>Payment Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                @php
                    $paymentDetails = json_decode($invoice->payment_details, true);
                    $latestPayment = !empty($paymentDetails) ? end($paymentDetails) : null;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->course->name_of_course }}</td>
                    <td>{{ $latestPayment ? getOrdinal($latestPayment['payment_type']) : '-' }}</td>
                    <td>₹{{ number_format($latestPayment['amount'] ?? 0, 2) }}</td>
                    <td>{{ $latestPayment['transaction_type'] ?? '-' }}</td>
                    <td>
                        <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-success">Print</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
