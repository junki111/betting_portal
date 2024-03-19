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

                <div class="row text-center">
                    <div class="col-12">
                        <h4 class="header-title mt-0 mb-1">User Bets</h4>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Bet User</th>
                                <th>Bet Amount</th>
                                <th>Potential Win Amount</th>
                                <th>Result</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bets as $bet)
                                <tr>
                                    <td class="align-middle">{{ user_name($bet->user_id) }}</td>
                                    <td class="align-middle">
                                        <span>{{ $bet->bet_amount }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ round($bet->bet_potential_winnings, 2) }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if ($bet->result == 'win')
                                            <span class="badge badge-success" id="result">{{ $bet->result }}</span>
                                        @elseif ($bet->result == 'loss')
                                            <span class="badge badge-danger" id="result">{{ $bet->result }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ($bet->status == 1)
                                            <span class="badge badge-info">Pending</span>
                                        @elseif ($bet->status == 2)
                                            <span class="badge badge-success">Completed</span>
                                        @elseif ($bet->status == 3)
                                            <span class="badge badge-warning">Active</span>
                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @can('view_bets')
                                            <a href="{{ route('bets.show', $bet->id) }}" title="View Bet"
                                                class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top"><i class="uil uil-eye"></i>
                                            </a>
                                        @endcan
                                        @can('delete_bets')
                                            <form id="delete-bet-{{ $bet->id }}"
                                                action="{{ route('bets.destroy', $bet->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" data-toggle="tooltip"
                                                    data-placement="top" title="Soft-Delete Bet"
                                                    onclick="return confirm('Are you sure you want to cancel this bet?');">
                                                    <i class="uil uil-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        {{-- @can('restore_bets')
                                                <form id="delete-bet-{{ $bet->id }}"
                                                    action="{{ route('users.restore', $bet->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-soft-success"
                                                        data-toggle="tooltip" data-placement="top" title="Restore Bet"
                                                        onclick="return confirm('Are you sure you want to restore this bet?');">
                                                        <i class="uil uil-redo"></i>
                                                    </button>
                                                </form>
                                            @endcan --}}
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

@section('script')
    <!-- datatable js -->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
@endsection

@section('script-bottom')
    <!-- Datatables init -->
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
