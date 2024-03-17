@extends('layouts.main')


@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <h4 class="float-left mt-1">
                User Data for: <i class="font-weight-bold">
                    {{ ucwords($user->first_name) . ' ' . ucwords($user->last_name) }}
                </i>
            </h4>
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </nav>
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
                            <h4 class="header-title mt-0 mb-1">View User</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('view_users')
                                @if (Auth::user()->type != 3)
                                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-soft-primary float-right"
                                        rel="tooltip" data-placement="top" title="Back to Users">
                                        <i class="uil uil-arrow-left"> Back to Users</i>
                                    </a>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-10">
                        <div class="form-group row mb-3">
                            <label for="first_name" class="col-3 col-form-label"><span class="badge badge-dark">First
                                    Name</span></label>
                            <div class="col-9">
                                <h5 id="first_name">{{ $user->first_name }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="last_name" class="col-3 col-form-label"><span class="badge badge-dark">Last
                                    Name</span></label>
                            <div class="col-9">
                                <h5 id="last_name">{{ $user->last_name }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="email" class="col-3 col-form-label"><span
                                    class="badge badge-dark">Email</span></label>
                            <div class="col-9">
                                <h5 id="email">{{ $user->email }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="msisdn" class="col-3 col-form-label"><span class="badge badge-dark">Phone
                                    Number</span></label>
                            <div class="col-9">
                                <h5 id="msisdn">{{ $user->msisdn }}</h5>
                            </div>
                        </div>

                        @if (Auth::user()->type == 3)
                            <div class="form-group row mb-3">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-md btn-soft-primary"
                                    data-toggle="tooltip" data-placement="top" title="Edit User">
                                    <i class="uil uil-edit-alt"></i>Edit User
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
