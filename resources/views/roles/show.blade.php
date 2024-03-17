@extends('layouts.main')

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Role Permissions</li>
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
                            @can('view_roles')
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-soft-primary float-right"
                                    rel="tooltip" data-placement="top" title="Back to Roles">
                                    <i class="uil uil-arrow-left"> Back to Roles</i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table m-0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-entry-id="{{ $role->id }}">
                                <td>{{ $role->id ?? '' }}</td>
                                <td>{{ ucwords($role->name ?? '') }}</td>
                                <td>
                                    @foreach ($role->permissions as $key => $permission)
                                        <span class="badge badge-info badge-many">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
@endsection
