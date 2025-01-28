@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Course Fee Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('course_fees.create') }}">
                    <i class="fa fa-plus"></i> Add New
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Course Name</th>
                                <th>Course Fee</th>
                                <th>Remaining Amount</th>
                                <th>1st Payment</th>
                                <th>2nd Payment</th>
                                <th>3rd Payment</th>
                                <th>4th Payment</th>
                                <th width="280px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courseFees as $fee)
                                <tr>
                                    <?php
                                        $remainingAmount = 0;

                                        if ($fee->first_payment_status != 1) {
                                            $remainingAmount += $fee->first_payment;
                                        }

                                        if ($fee->second_payment_status != 1) {
                                            $remainingAmount += $fee->second_payment;
                                        }

                                        if ($fee->fourth_payment_status != 1) {
                                            $remainingAmount += $fee->fourth_payment;
                                        }

                                        $remainingAmount += $fee->third_payment; // third_payment has no condition as per your request
                                    ?>

                                    <td>{{ $fee->user->name }}</td>
                                    <td>{{ $fee->course->name_of_course }}</td>
                                    <td>{{ $fee->course_fee }}</td>
                                    <td>{{ number_format($remainingAmount, 2, '.', '') }}</td>


                                    <!-- 1st Payment -->

                                    <td>
                                        @if($fee->first_payment && $fee->first_payment_date)
                                            @if($fee->first_payment_status == 1)
                                                <del>0.00 / {{ \Carbon\Carbon::parse($fee->first_payment_date)->format('d-m-Y') }}</del>
                                            @else
                                                {{ $fee->first_payment }} / {{ \Carbon\Carbon::parse($fee->first_payment_date)->format('d-m-Y') }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <!-- 2nd Payment -->

                                    <td>
                                        @if($fee->second_payment && $fee->second_payment_date)
                                            @if($fee->second_payment_status == 1)
                                                <del>0.00 / {{ \Carbon\Carbon::parse($fee->second_payment_date)->format('d-m-Y') }}</del>
                                            @else
                                                {{ $fee->second_payment }} / {{ \Carbon\Carbon::parse($fee->second_payment_date)->format('d-m-Y') }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <!-- 3rd Payment -->
                                    <td>
                                        @if($fee->third_payment && $fee->third_payment_date)
                                            @if($fee->third_payment_status == 1)
                                                <del>0.00 / {{ \Carbon\Carbon::parse($fee->third_payment_date)->format('d-m-Y') }}</del>
                                            @else
                                                {{ $fee->third_payment }} / {{ \Carbon\Carbon::parse($fee->third_payment_date)->format('d-m-Y') }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <!-- 4th Payment -->

                                    <td>
                                        @if($fee->fourth_payment && $fee->fourth_payment_date)
                                            @if($fee->fourth_payment_status == 1)
                                                <del>0.00 / {{ \Carbon\Carbon::parse($fee->fourth_payment_date)->format('d-m-Y') }}</del>
                                            @else
                                                {{ $fee->fourth_payment }} / {{ \Carbon\Carbon::parse($fee->fourth_payment_date)->format('d-m-Y') }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('course_fees.edit', $fee->id) }}">
                                            <i class="fa-solid far fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('course_fees.destroy', $fee->id) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection