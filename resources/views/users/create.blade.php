@extends('layouts.main')

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Create User</h4>
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
                            <h4 class="header-title mt-0 mb-1">New User</h4>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-soft-primary float-right">
                                <i class="uil uil-arrow-left"> Back to Users</i>
                            </a>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xl-10">
                            <form action="{{ route('users.create') }}" method="post">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="firstName3" class="col-3 col-form-label">First Name</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="firstName3" placeholder="First Name"
                                            required value="{{ old('first_name') }}" name="first_name">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="lastName3" class="col-3 col-form-label">Last Name</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="lastName3" placeholder="Last Name"
                                            required value="{{ old('last_name') }}" name="last_name">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="email3" class="col-3 col-form-label">Email (Username)</label>
                                    <div class="col-9">
                                        <input type="email" class="form-control" id="email3" placeholder="Email"
                                            required value="{{ old('email') }}" name="email">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="phoneNumber" class="col-3 col-form-label">Phone Number</label>
                                    <div class="col-9">
                                        <input type="number" class="form-control" id="phoneNumber"
                                            placeholder="Phone Number" required value="{{ old('msisdn') }}" name="msisdn">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="role" class="col-3 col-form-label">Role</label>
                                    <div class="col-9">
                                        <select name="type" id="role" class="form-group custom-select" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-2"><i
                                            class="uil uil-location-arrow"></i> Submit</button>
                                </div>
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
