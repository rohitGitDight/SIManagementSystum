@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Course Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('courses.create') }}"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
    </div>

    @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
    @endsession
    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Multi Filter Select</h4>
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Duration</th>
                                <th>Fee</th>
                                <th>Batches</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $course)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $course->name_of_course }}</td>
                                    <td>{{ $course->duration }}</td>
                                    <td>{{ $course->fee }}</td>
                                    <td>{{ $course->batches }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('courses.show', $course->id) }}"><i
                                                class="fa-solid far fa-eye"></i></a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('courses.edit', $course->id) }}"><i
                                                class="fa-solid far fa-edit"></i></a>
                                        <form method="POST" action="{{ route('courses.destroy', $course->id) }}" class="delete-form" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                        
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">
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
    {{-- {!! $data->links('pagination::bootstrap-5') !!} --}}
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                let form = this.closest('.delete-form');
                
                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
