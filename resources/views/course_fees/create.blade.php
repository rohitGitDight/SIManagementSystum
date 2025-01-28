@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Add Course Fee</h2>
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

    <form method="POST" action="{{ route('course_fees.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Student Name:</strong>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Select Student --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Name:</strong>
                    <input type="text" name="course_name" id="course_name" class="form-control" readonly>
                    <input type="hidden" name="course_id" id="course_id"> <!-- Hidden field for processing -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Duration (in days):</strong>
                    <input type="number" name="course_duration" id="course_duration" class="form-control" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Fee:</strong>
                    <input type="number" name="course_fee" id="course_fee" placeholder="Course Fee" class="form-control" value="{{ old('course_fee') }}" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course Start Date:</strong>
                    <input type="date" name="course_start_date" id="course_start_date" class="form-control" required>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
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
                }
            });
        });
    </script>
@endsection
