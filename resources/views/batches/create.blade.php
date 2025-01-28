@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Create New Batch</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('batches.index') }}"><i class="fa fa-arrow-left"></i>
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

    <form method="POST" action="{{ route('batches.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Batch Name:</strong>
                    <input type="text" name="batch_name" placeholder="Batch Name" class="form-control"
                        value="{{ old('batch_name') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Start Time:</strong>
                    <input type="time" name="start_time" placeholder="Start Time" class="form-control"
                        value="{{ old('start_time') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <strong>End Time:</strong>
                    <input type="time" name="end_time" placeholder="End Time" class="form-control"
                        value="{{ old('end_time') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Course:</strong>
                    <select name="course_id" class="form-control">
                        <option value="">-- Select Course --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name_of_course }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </div>
    </form>
@endsection