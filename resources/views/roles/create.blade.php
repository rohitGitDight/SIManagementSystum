@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Create New Role</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
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

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" placeholder="Name" class="form-control">
                </div>
            </div>
        </div>

        <h4 class="mt-3">Permissions</h4>

        <div class="row">
            @php
                $groupedPermissions = [
                    'Student' => ['add student', 'edit student', 'view student', 'delete student', 'view student list'],
                    'Role' => ['view role', 'edit role', 'view role list'],
                    'Batch' => ['view batch', 'add batch', 'edit batch', 'delete batch', 'view batch list'],
                    'Course' => ['view course', 'add course', 'edit course', 'delete course', 'view course list'],
                    'Professor' => ['view professor', 'add professor', 'edit professor', 'delete professor', 'view professor list'],
                    'Fee Transactions' => ['view student fee transactions', 'edit student fee transaction'],
                    'Student Course Fees' => ['view student course fees', 'add student course fees'],
                    'Payment Calendar' => ['view student payment calendar'],
                    'Invoices' => ['view invoice list', 'view student personal invoice list'],
                ];
            @endphp

            @foreach ($groupedPermissions as $category => $permissions)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-primary text-white fw-bold">{{ $category }}</div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($permissions as $permName)
                                    @php
                                        $perm = $permission->firstWhere('name', $permName);
                                    @endphp
                                    @if ($perm)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[{{ $perm->id }}]" value="{{ $perm->id }}" 
                                                    class="form-check-input">
                                                <label class="form-check-label">{{ $perm->name }}</label>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </div>
    </form>
@endsection
