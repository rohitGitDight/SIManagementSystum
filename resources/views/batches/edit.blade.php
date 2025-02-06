@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Edit Batch</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('batches.index') }}">
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

    <form method="POST" action="{{ route('batches.update', $batch->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Batch Information -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Batch Name:</strong></label>
                    <input type="text" name="batch_name" class="form-control" placeholder="Batch Name"
                        value="{{ old('batch_name', $batch->batch_name) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Start Time:</strong></label>
                    <input type="time" name="start_time" class="form-control" placeholder="Start Time"
                        value="{{ old('start_time', \Carbon\Carbon::parse($batch->start_time)->format('H:i')) }}">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>End Time:</strong></label>
                    <input type="time" name="end_time" class="form-control" placeholder="End Time"
                        value="{{ old('end_time', \Carbon\Carbon::parse($batch->end_time)->format('H:i')) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Course:</strong></label>
                    <select name="course_id" class="form-control">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $batch->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name_of_course }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><strong>Batch Start Date:</strong></label>
                    <input type="date" name="batch_start_date" class="form-control" 
                        value="{{ old('batch_start_date', $batch->batch_start_date) }}">
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