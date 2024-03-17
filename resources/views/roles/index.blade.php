@extends('layouts.main')

@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-itemactive" aria-current="page">Roles</a></li>
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
                            <h4 class="header-title mt-0 mb-4">Role Management</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('create_roles')
                                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-soft-primary float-right"
                                    data-toggle="tooltip" data-placement="top" title="Add Role"><i data-feather="plus"></i>Add
                                    Role
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <div class="hidden" hidden>{{ $i = 1 }}</div>
                        <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr data-entry-id="{{ $role->id }}">

                                        <td class="align-middle">{{ $i++ }}</td>
                                        <td class="align-middle">{{ ucwords($role->name ?? '') }}</td>
                                        <td class="align-middle">{{ strtolower($role->description ?? '') }}</td>
                                        <td class="text-center align-middle">
                                            @can('edit_roles')
                                                <a href="{{ route('roles.edit', $role->id) }}" title="Edit Role"
                                                    class="btn btn-outline-primary btn-sm" rel="tooltip"
                                                    data-placement="top"><i class="uil uil-edit-alt"></i>
                                                </a>
                                            @endcan
                                            @can('view_roles')
                                                <a href="{{ route('roles.show', $role->id) }}" title="view Role"
                                                    class="btn btn-outline-primary btn-sm" rel="tooltip"
                                                    data-placement="top"><i class="uil uil-eye"></i> view
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- datatable js -->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
@endsection

@section('script-bottom')
    <!-- Datatables init -->
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
