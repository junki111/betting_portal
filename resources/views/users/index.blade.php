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
                    <li class="breadcrumb-item active" aria-current="page"><a href="">User Management</a></li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Users</h4>
        </div>
    </div>
@endsection

@section('content')
    @include('flash.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="header-title mt-0 mb-4">User Management</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('create_users')
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-soft-primary float-right  mr-2"
                                    data-toggle="tooltip" data-placement="top" title="Add User">
                                    <i class="uil uil-plus"> Add User</i>
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="align-middle">{{ $user->first_name }}</td>
                                        <td class="align-middle">{{ $user->last_name }}</td>
                                        <td class="align-middle">{{ $user->email }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-primary">{{ role_name($user->type) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if ($user->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @can('view_users')
                                                <a href="{{ route('users.show', $user->id) }}" title="View User"
                                                    class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                    data-placement="top"><i class="uil uil-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit_users')
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-soft-primary" data-toggle="tooltip"
                                                    data-placement="top" title="Edit User">
                                                    <i class="uil uil-pen"></i>
                                                </a>
                                            @endcan
                                            @can('delete_users')
                                                <form id="delete-user-{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Soft-Delete User"
                                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                                        <i class="uil uil-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('restore_users')
                                                <form id="delete-user-{{ $user->id }}"
                                                    action="{{ route('users.restore', $user->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-soft-success"
                                                        data-toggle="tooltip" data-placement="top" title="Restore User"
                                                        onclick="return confirm('Are you sure you want to restore this user?');">
                                                        <i class="uil uil-redo"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
