@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('students.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- User Information -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Name:</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $user->name) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Email:</strong></label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $user->email) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Password:</strong></label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Confirm Password:</strong></label>
                    <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password">
                </div>
            </div>

            <!-- User Details -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Date of Birth:</strong></label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->details->dob ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Married:</strong></label>
                    <select name="married" class="form-control">
                        <option value="1" {{ old('married', $user->details->married ?? '') == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('married', $user->details->married ?? '') == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            @php
                $details = $user->details ?? null;
            @endphp

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Contact:</strong></label>
                    <input type="text" name="contact" class="form-control" placeholder="Contact" value="{{ old('contact', $details->contact ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Father's Name:</strong></label>
                    <input type="text" name="father_name" class="form-control" placeholder="Father's Name" value="{{ old('father_name', $details->father_name ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Mother's Name:</strong></label>
                    <input type="text" name="mother_name" class="form-control" placeholder="Mother's Name" value="{{ old('mother_name', $details->mother_name ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Father's Mobile:</strong></label>
                    <input type="text" name="father_mobile" class="form-control" placeholder="Father's Mobile" value="{{ old('father_mobile', $details->father_mobile ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Mother's Mobile:</strong></label>
                    <input type="text" name="mother_mobile" class="form-control" placeholder="Mother's Mobile" value="{{ old('mother_mobile', $details->mother_mobile ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Address:</strong></label>
                    <textarea name="address" class="form-control" placeholder="Address">{{ old('address', $details->address ?? '') }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>City:</strong></label>
                    <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city', $details->city ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>State:</strong></label>
                    <input type="text" name="state" class="form-control" placeholder="State" value="{{ old('state', $details->state ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Course:</strong></label>
                    <select name="course" class="form-control" id="course-select">
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" 
                                {{ old('course', $user->details->course ?? '') == $course->id ? 'selected' : '' }}>
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
                        @foreach ($courseBatch as $batch)
                            <option value="{{ $batch->id }}" 
                                {{ old('student_batch', $user->details->student_batch ?? '') == $batch->id ? 'selected' : '' }}>
                                {{ $batch->batch_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Batch Professor:</strong>
                    <select name="batch_professor" class="form-control" id="student-professor-select">
                        <option value="">Select Professor</option>
                        @foreach ($proffesors as $proffesor)
                            <option value="{{ $proffesor->userName->id }}" 
                                {{ old('student_batch', $user->details->batch_professor ?? '') == $proffesor->userName->id ? 'selected' : '' }}>
                                {{ $proffesor->userName->name }}
                            </option>
                        @endforeach                    
                    </select>
                </div>
            </div>

            <!-- Course Start Date -->
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Course Start Date:</strong>
                    <input type="date" name="course_start_date" class="form-control" value="{{ old('course_start_date' , $details->course_start_date ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Fee:</strong></label>
                    <input type="text" name="fee" class="form-control" placeholder="Fee" value="{{ old('fee', $details->fee ?? '') }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Upload Profile Image:</strong>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fa fa-save"></i> Update
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
                            var option = document.createElement('option');
                            option.value = professor.user_name.id;
                            option.textContent = professor.user_name.name;
                            professorSelect.appendChild(option);
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
