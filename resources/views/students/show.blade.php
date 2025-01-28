@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Show User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('students.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fa fa-user"></i> User Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Email:</strong>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Date of Birth:</strong>
                                <p>{{ $user->details->dob ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Marital Status:</strong>
                                <p>{{ $user->details->married ? 'Married' : 'Single' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Contact:</strong>
                                <p>{{ $user->details->contact ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Father's Name:</strong>
                                <p>{{ $user->details->father_name ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Mother's Name:</strong>
                                <p>{{ $user->details->mother_name ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Father's Mobile:</strong>
                                <p>{{ $user->details->father_mobile ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Mother's Mobile:</strong>
                                <p>{{ $user->details->mother_mobile ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Address:</strong>
                                <p>{{ $user->details->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>City:</strong>
                                <p>{{ $user->details->city ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>State:</strong>
                                <p>{{ $user->details->state ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Course:</strong>
                                <p>{{ $user->details->course ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Batch:</strong>
                                <p>{{ $user->details->student_batch ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Professor:</strong>
                                <p>{{ $user->details->batch_professor ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Fee:</strong>
                                <p>{{ $user->details->fee ? '₹' . number_format($user->details->fee, 2) : 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Aadhaar Card Number:</strong>
                                <p>{{ $user->details->aadhaar_card_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection