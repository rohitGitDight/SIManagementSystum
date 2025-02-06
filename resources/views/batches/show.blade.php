@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Show Batch</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('batches.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fa fa-calendar"></i> Batch Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Batch Name:</strong>
                                <p>{{ $batch->batch_name }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Start Time:</strong>
                                <p>{{ \Carbon\Carbon::parse($batch->start_time)->format('h:i A') }}</p>
                            </div>
                            <div class="form-group">
                                <strong>End Time:</strong>
                                <p>{{ \Carbon\Carbon::parse($batch->end_time)->format('h:i A') }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Course:</strong>
                                <p>{{ $batch->course->name_of_course }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Batch Start Date:</strong>
                                <p>{{ $batch->batch_start_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection