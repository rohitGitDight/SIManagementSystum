@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Create New User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('students.index') }}"><i class="fa fa-arrow-left"></i>
                    Back</a>
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

    <form method="POST" action="{{ route('students.store') }}"  enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- User Basic Information -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
                </div>
            </div>

            <!-- User Details -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Date of Birth:</strong>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Married:</strong>
                    <select name="married" class="form-control">
                        <option value="0" {{ old('married') == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('married') == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Contact:</strong>
                    <input type="text" name="contact" placeholder="Contact" class="form-control" value="{{ old('contact') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Father's Name:</strong>
                    <input type="text" name="father_name" placeholder="Father's Name" class="form-control" value="{{ old('father_name') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Mother's Name:</strong>
                    <input type="text" name="mother_name" placeholder="Mother's Name" class="form-control" value="{{ old('mother_name') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Father's Mobile:</strong>
                    <input type="text" name="father_mobile" placeholder="Father's Mobile" class="form-control" value="{{ old('father_mobile') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Mother's Mobile:</strong>
                    <input type="text" name="mother_mobile" placeholder="Mother's Mobile" class="form-control" value="{{ old('mother_mobile') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Address:</strong>
                    <textarea name="address" placeholder="Address" class="form-control">{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>City:</strong>
                    <input type="text" name="city" placeholder="City" class="form-control" value="{{ old('city') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>State:</strong>
                    <input type="text" name="state" placeholder="State" class="form-control" value="{{ old('state') }}">
                </div>
            </div>
            <!-- Course Selection -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Course:</strong>
                    <select name="course" class="form-control" id="course-select">
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course') == $course->id ? 'selected' : '' }}>
                                {{ $course->name_of_course }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Student Batch Selection (Dynamic) -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Student Batch:</strong>
                    <select name="student_batch" class="form-control" id="student-batch-select">
                        <option value="">Select Batch</option>
                        <!-- Batches will be dynamically loaded here -->
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Batch Professor:</strong>
                    <select name="batch_professor" class="form-control" id="student-professor-select">
                        <option value="">Select Professor</option>
                        <!-- Batches will be dynamically loaded here -->
                    </select>
                </div>
            </div>

            <!-- Course Start Date -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Course Start Date:</strong>
                    <input type="date" name="course_start_date" class="form-control" value="{{ old('course_start_date') }}">
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Fee:</strong>
                    <input type="number" id="courseFee" step="0.01" name="fee" placeholder="Fee" class="form-control" value="{{ old('fee') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Aadhaar Card Number:</strong>
                    <input type="text" name="aadhaar_card_number" placeholder="Aadhaar Card Number" class="form-control" value="{{ old('aadhaar_card_number') }}">
                </div>
            </div>

            <!-- Image Upload Section -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Upload Profile Image:</strong>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </div>
    </form>
    <!-- JavaScript to handle dynamic batch loading -->
    <script>
        document.getElementById('course-select').addEventListener('change', function() {
            var courseId = this.value;

            if (courseId) {
                // Fetch batches for the selected course using AJAX
                fetch(`/get-batches/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        var batchSelect = document.getElementById('student-batch-select');
                        batchSelect.innerHTML = '<option value="">Select Batch</option>'; // Reset batch options
                        data.batches.forEach(function(batch) {
                            var option = document.createElement('option');
                            option.value = batch.id;
                            option.textContent = batch.batch_name;
                            batchSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching batches:', error));

                // Fetch professors for the selected course using AJAX
                fetch(`/get-professors/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        var professorSelect = document.getElementById('student-professor-select');
                        professorSelect.innerHTML = '<option value="">Select Professor</option>'; // Reset professor options
                        data.professors.forEach(function(professor) {
                            console.log(professor);
                            var option = document.createElement('option');
                            option.value = professor.user_name.id;
                            option.textContent = professor.user_name.name;
                            professorSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching professors:', error));
                // Fetch professors for the selected course using AJAX
                fetch(`/get-courseFee/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.courseFee.forEach(function(courseFees) {
                            console.log(courseFees.fee);
                            var professorSelect = document.getElementById('courseFee');
                            professorSelect.value = courseFees.fee;
                            professorSelect.textContent = courseFees.fee;
                        });
                    })
                    .catch(error => console.error('Error fetching professors:', error));
            } else {
                // Clear both batch and professor dropdowns if no course is selected
                document.getElementById('student-batch-select').innerHTML = '<option value="">Select Batch</option>';
                document.getElementById('student-professor-select').innerHTML = '<option value="">Select Professor</option>';
            }

        });
    </script>
@endsection
