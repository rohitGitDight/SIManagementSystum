@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Show Course</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('courses.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fa fa-user"></i> Course Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Name of Course:</strong>
                                <p>{{ $course->name_of_course }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Duration:</strong>
                                <p>{{ $course->duration }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Fee:</strong>
                                <p>{{ $course->fee }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Professor:</strong>
                                <p>{{ $professor->name }}</p>
                            </div>
                            <div class="form-group">
                                <strong>Batches:</strong>
                                <p>{{ $course->batches }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
