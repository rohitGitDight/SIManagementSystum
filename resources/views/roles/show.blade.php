@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2 class="text-primary">Role Details</h2>
                <a class="btn btn-outline-primary" href="{{ route('roles.index') }}">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="mb-3 text-secondary">Role Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong class="text-dark">Name:</strong>
                            <span class="text-muted">{{ $role->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong class="text-dark">Permissions:</strong>
                            <div class="mt-2">
                                @if (!empty($rolePermissions))
                                    @foreach ($rolePermissions as $v)
                                        <span class="badge bg-success text-white me-1">{{ $v->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No permissions assigned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection