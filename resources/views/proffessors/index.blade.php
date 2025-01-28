@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Proffessor Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('proffessors.create') }}"><i class="fa fa-plus"></i> Add New</a>
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
                                <th>Email</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->userName->name }}</td>
                                    <td>{{ $user->userName->email }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('proffessors.show', $user->userName->id) }}"><i
                                                class="fa-solid far fa-eye"></i></a>
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('proffessors.edit', $user->userName->id) }}"><i
                                                class="fa-solid far fa-edit"></i></a>
                                        <form method="POST"
                                            action="{{ route('proffessors.destroy', $user->userName->id) }}"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa-solid fas fa-trash-alt"></i>
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
