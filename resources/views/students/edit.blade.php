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
                    <select name="course" class="form-control">
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

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Fee:</strong></label>
                    <input type="text" name="fee" class="form-control" placeholder="Fee" value="{{ old('fee', $details->fee ?? '') }}">
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fa fa-save"></i> Update
                </button>
            </div>
        </div>
    </form>
@endsection
