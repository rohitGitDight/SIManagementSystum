@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Edit Course</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('courses.index') }}">
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

    <form method="POST" action="{{ route('courses.update', $course->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Course Information -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Name of Course:</strong></label>
                    <input type="text" name="name_of_course" class="form-control" placeholder="Name of Course"
                        value="{{ old('name_of_course', $course->name_of_course) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Duration:</strong></label>
                    <input type="text" name="duration" class="form-control" placeholder="Duration"
                        value="{{ old('duration', $course->duration) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Fee:</strong></label>
                    <input type="number" name="fee" class="form-control" placeholder="Fee"
                        value="{{ old('fee', $course->fee) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Professor:</strong></label>
                    <input type="text" name="professor" class="form-control" placeholder="Professor Name"
                        value="{{ old('professor', $course->professor) }}">
                </div>
            </div>

            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Batches:</strong></label>
                    <input type="number" name="batches" class="form-control" placeholder="Number of Batches"
                        value="{{ old('batches', $course->batches) }}">
                </div>
            </div> --}}

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Installment Cycle:</strong></label>
                    <input type="number" name="installment_cycle" class="form-control" placeholder="Number of installment Cycles"
                        value="{{ old('installment_cycle', $course->installment_cycle) }}">
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
