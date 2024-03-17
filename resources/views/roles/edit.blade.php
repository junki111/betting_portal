@extends('layouts.main')

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Roles</h4>
        </div>
    </div>
@endsection

@section('content')
    @include('flash.message')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="header-title mt-0 mb-1">Role Management</h4>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-soft-primary float-right"
                                rel="tooltip" data-placement="top" title="Back to Roles">
                                <i class="uil uil-arrow-left"> Back to Roles</i>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-10">
                            <form method="POST" action="{{ route('roles.edit', $role->id) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $role->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Role Description</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        value="{{ $role->description }}" required>
                                </div>

                                <h5><i data-feather="edit-3"></i> Assign Permissions</h5><br>

                                <div class="form-check ">
                                    @foreach ($permissions as $permission)
                                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}"
                                            id="permission{{ $permission->id }}" name="permissions[]"
                                            {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check" for="permission{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label><br>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update Role</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
