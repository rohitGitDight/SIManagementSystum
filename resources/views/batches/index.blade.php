@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Batch Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('batches.create') }}">
                    <i class="fa fa-plus"></i> Add New
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Course</th>
                                <th>Batch Start Date</th>
                                <th>Number Of Students</th>
                                <th width="280px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($batches as $batch)
                                <tr>
                                    <td>{{ $batch->id }}</td>
                                    <td>{{ $batch->batch_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($batch->start_time)->format('h:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($batch->end_time)->format('h:i A') }}</td>
                                    <td>{{ $batch->course->name_of_course }}</td>
                                    <td>{{ $batch->batch_start_date ? $batch->batch_start_date : "-" }}</td>
                                    @php
                                        $studentCount = \App\Models\UserDetail::where('student_batch' , $batch->id)->count();
                                    @endphp
                                    <td>{{ $studentCount ? $studentCount : '-' }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('batches.show', $batch) }}">
                                            <i class="fa-solid far fa-eye"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('batches.edit', $batch) }}">
                                            <i class="fa-solid far fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('batches.destroy', $batch) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection