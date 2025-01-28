@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Edit Course Fee</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('course_fees.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('course_fees.update', $courseFee->id) }}">
        @csrf
        @method('PUT') <!-- Use PUT method for updating -->
        <div class="row">
            <!-- Student Name -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Student Name:</strong>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Select Student --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ $courseFee->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Course Name -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Name:</strong>
                    <input type="text" name="course_name" id="course_name" class="form-control" value="{{ old('course_name', $courseFee->course->name_of_course ) }}" readonly>
                    <input type="hidden" name="course_id" id="course_id" value="{{ old('course_id', $courseFee->course_id) }}">
                </div>
            </div>

            <!-- Course Duration -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Duration (in days):</strong>
                    <input type="number" name="course_duration" id="course_duration" class="form-control" value="{{ old('course_duration', $courseFee->course->duration) }}" readonly>
                </div>
            </div>

            <!-- Course Fee -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Fee:</strong>
                    <input type="number" name="course_fee" id="course_fee" class="form-control" value="{{ old('course_fee', $courseFee->course_fee) }}" required>
                </div>
            </div>

            <!-- Course Start Date -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Start Date:</strong>
                    <input type="date" name="course_start_date" id="course_start_date" class="form-control" value="{{ old('course_start_date', $courseFee->course_start_date) }}" required>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>First Payment Amount</strong>
                    <input type="text" name="first_payment" id="first_payment" class="form-control" value="{{ old('first_payment', $courseFee->first_payment) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>First Payment Date</strong>
                    <input type="date" name="first_payment_date" id="first_payment_date" class="form-control" value="{{ old('first_payment_date', $courseFee->first_payment_date) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Second Payment Amount</strong>
                    <input type="text" name="second_payment" id="second_payment" class="form-control" value="{{ old('second_payment', $courseFee->second_payment) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Second Payment Date</strong>
                    <input type="date" name="second_payment_date" id="second_payment_date" class="form-control" value="{{ old('second_payment_date', $courseFee->second_payment_date) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Third Payment Amount</strong>
                    <input type="text" name="third_payment" id="third_payment" class="form-control" value="{{ old('third_payment', $courseFee->third_payment) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Third Payment Date</strong>
                    <input type="date" name="third_payment_date" id="third_payment_date" class="form-control" value="{{ old('third_payment_date', $courseFee->third_payment_date) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Fourth Payment Amount</strong>
                    <input type="text" name="fourth_payment" id="fourth_payment" class="form-control" value="{{ old('fourth_payment', $courseFee->fourth_payment) }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Fourth Payment Date</strong>
                    <input type="date" name="fourth_payment_date" id="fourth_payment_date" class="form-control" value="{{ old('fourth_payment_date', $courseFee->fourth_payment_date) }}" readonly>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary mt-2 mb-3">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener for when the Course Fee is changed
            $('#course_fee').on('input', function() {
                updatePayments();
            });

            // Event listener for when the Course Duration is changed
            $('#course_duration').on('input', function() {
                updatePayments();
            });

            // Event listener for when the Course Start Date is changed
            $('#course_start_date').on('change', function() {
                updatePayments();
            });

            // Event listener for when the User (student) is changed
            $('#user_id').change(function() {
                var studentId = $(this).val(); // Get the selected student ID
                if (studentId) {
                    $.ajax({
                        url: '/get-course-details/' + studentId, // Adjust route as needed
                        type: 'GET',
                        success: function(response) {
                            if (response) {
                                // Fill the course name and duration fields
                                $('#course_name').val(response.course_name);
                                $('#course_id').val(response.course_id);
                                $('#course_duration').val(response.course_duration);
                                $('#course_fee').val(response.course_fee);

                                // Update payment details as well
                                updatePayments();
                            }
                        },
                        error: function() {
                            alert('Error retrieving course details.');
                        }
                    });
                } else {
                    // Reset the fields if no student is selected
                    $('#course_name').val('');
                    $('#course_duration').val('');
                    $('#course_fee').val('');
                    $('#course_start_date').val('');
                    updatePayments();  // Clear payment fields as well
                }
            });

            // Function to update payment information based on the course fee and duration
            function updatePayments() {
                var courseFee = parseFloat($('#course_fee').val());
                var courseDuration = parseInt($('#course_duration').val());
                var courseStartDate = $('#course_start_date').val();

                // Exit if any required field is invalid
                if (isNaN(courseFee) || isNaN(courseDuration) || !courseStartDate) {
                    return;
                }

                var installment = courseFee / 4;
                var interval = courseDuration / 4;  // Divide duration into 4 equal parts

                var startDate = new Date(courseStartDate);
                if (!startDate.getTime()) {
                    return; // Exit if the start date is invalid
                }

                // Calculate the payment dates
                var firstPaymentDate = formatDate(addDays(startDate, interval * 0)); // Add 0 days for the first payment
                var secondPaymentDate = formatDate(addDays(startDate, interval * 1)); // Add days for the second payment
                var thirdPaymentDate = formatDate(addDays(startDate, interval * 2));  // Add days for the third payment
                var fourthPaymentDate = formatDate(addDays(startDate, interval * 3)); // Add days for the fourth payment

                // Update the fields for the payment installments and dates
                $('#first_payment').val(installment.toFixed(2));
                $('#second_payment').val(installment.toFixed(2));
                $('#third_payment').val(installment.toFixed(2));
                $('#fourth_payment').val(installment.toFixed(2));

                $('#first_payment_date').val(firstPaymentDate);
                $('#second_payment_date').val(secondPaymentDate);
                $('#third_payment_date').val(thirdPaymentDate);
                $('#fourth_payment_date').val(fourthPaymentDate);
            }

            // Function to format date (YYYY-MM-DD)
            function formatDate(date) {
                var d = new Date(date);
                var month = ('0' + (d.getMonth() + 1)).slice(-2);
                var day = ('0' + d.getDate()).slice(-2);
                var year = d.getFullYear();
                return year + '-' + month + '-' + day;
            }

            // Function to add days to a given date
            function addDays(date, days) {
                var result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
            }
        });
    </script>
@endsection