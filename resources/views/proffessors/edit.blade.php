@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Edit Proffessor</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('proffessors.index') }}">
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

    <form method="POST" action="{{ route('proffessors.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- User Information -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Name:</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name"
                        value="{{ old('name', $user->name) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Email:</strong></label>
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email', $user->email) }}">
                </div>
            </div>
            <!-- User Details -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Date of Birth:</strong></label>
                    <input type="date" name="dob" class="form-control"
                        value="{{ old('dob', $user->details->dob ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Married:</strong></label>
                    <select name="married" class="form-control">
                        <option value="1" {{ old('married', $user->details->married ?? '') == 1 ? 'selected' : '' }}>
                            Yes</option>
                        <option value="0" {{ old('married', $user->details->married ?? '') == 0 ? 'selected' : '' }}>No
                        </option>
                    </select>
                </div>
            </div>

            @php
                $details = $user->details ?? null;
            @endphp

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Contact:</strong></label>
                    <input type="text" name="contact" class="form-control" placeholder="Contact"
                        value="{{ old('contact', $details->contact ?? '') }}">
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
                    <input type="text" name="city" class="form-control" placeholder="City"
                        value="{{ old('city', $details->city ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>State:</strong></label>
                    <input type="text" name="state" class="form-control" placeholder="State"
                        value="{{ old('state', $details->state ?? '') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Course:</strong></label>
                    <input type="text" name="course" class="form-control" placeholder="Course"
                        value="{{ old('course', $details->course ?? '') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Aadhaar Card Number:</strong>
                    <input type="text" name="aadhaar_card_number" placeholder="Aadhaar Card Number" class="form-control"
                        value="{{ old('aadhaar_card_number', $details->aadhaar_card_number ?? '') }}">
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
