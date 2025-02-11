@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Users Management</h2>
            </div>
            <div class="pull-right">
                @can('add student') <!-- Ensuring only users with 'add student' permission can see this button -->
                    <a class="btn btn-success mb-2" href="{{ route('students.create') }}">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                @endcan
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
            {{-- <div class="card-body">
                <div class="table-responsive">
                    <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('students.show', $user->id) }}"><i
                                                class="fa-solid far fa-eye"></i></a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('students.edit', $user->id) }}"><i
                                                class="fa-solid far fa-edit"></i></a>
                                        <form method="POST" action="{{ route('students.destroy', $user->id) }}" class="delete-form" style="display:inline">
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
            </div> --}}

            <div class="card-body">
                <div class="table-responsive">
                    <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                @canany(['view student', 'edit student', 'delete student'])
                                    <th width="280px">Action</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @canany(['view student', 'edit student', 'delete student'])
                                        <td>
                                            @can('view student')
                                                <a class="btn btn-info btn-sm" href="{{ route('students.show', $user->id) }}">
                                                    <i class="fa-solid far fa-eye"></i>
                                                </a>
                                            @endcan
            
                                            @can('edit student')
                                                <a class="btn btn-primary btn-sm" href="{{ route('students.edit', $user->id) }}">
                                                    <i class="fa-solid far fa-edit"></i>
                                                </a>
                                            @endcan
            
                                            @can('delete student')
                                                <form method="POST" action="{{ route('students.destroy', $user->id) }}" class="delete-form" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="fa-solid fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    @endcanany
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
                    text: "Are you absolutely sure you want to delete this?",
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
