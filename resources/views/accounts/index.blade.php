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
                    <li class="breadcrumb-item active" aria-current="page"><a href="">Account Management</a></li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Accounts</h4>
        </div>
    </div>
@endsection

@section('content')
    @include('flash.message')
    <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Profit</span>
                            <h2 class="mb-0">
                                {{ Auth::user()->type == 1 ? round($total_losses, 2) : (Auth::user()->type == 2 ? round($total_losses, 2) : $total_wins) }}
                            </h2>
                        </div>
                        <div class="align-self-center">
                            <span class="text-info font-weight-bold font-size-13"><i class='uil uil-money-insert'></i>
                                Profit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Losses</span>
                            <h2 class="mb-0">
                                {{ Auth::user()->type == 1 ? round($total_wins, 2) : (Auth::user()->type == 2 ? round($total_wins, 2) : round($total_losses, 2)) }}
                            </h2>
                        </div>
                        <div class="align-self-center">
                            <span class="text-info font-weight-bold font-size-13"><i class='uil uil-money-insert'></i>
                                Losses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row mb-3">
                        <label for="filterSelect" class="col-2 col-form-label">Filter Results</label>
                        <div class="col-3">
                            <select id="filterSelect" class="form-group custom-select">
                                <option value="">All</option>
                                <option value="wins">Wins</option>
                                <option value="loss">Losses</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="header-title mt-0 mb-4">Account Management</h4>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th>Bet User</th>
                                    <th>Outcome</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td class="align-middle">{{ user_name($account->user_id) }}</td>
                                        <td class="align-middle">
                                            <span
                                                class="badge {{ $account->outcome == 'win' ? 'badge-success' : ($account->outcome == 'loss' ? 'badge-danger' : '') }}">{{ $account->outcome }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span>{{ round($account->amount, 2) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @can('view_bets')
                                                <a href="{{ route('bets.show', $account->bet_id) }}" title="View Bet"
                                                    class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                    data-placement="top"><i class="uil uil-eye"></i>
                                                </a>
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
    <script>
        var filterInput = document.getElementById('filterSelect');
        var table = document.getElementById('basic-datatable');
        var rows = table.getElementsByTagName('tr');

        // Add event listener for input field
        filterInput.addEventListener('change', function() {
            var filter = filterInput.value.toUpperCase(); // Convert filter text to uppercase
            // Loop through all table rows and hide those that don't match the filter
            for (var i = 0; i < rows.length; i++) {
                var td = rows[i].getElementsByTagName('td')[
                    1]; // Get the second column (index 1) of the current row
                if (td) {
                    var textValue = td.textContent || td.innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = ''; // Show row if it matches filter
                    } else {
                        rows[i].style.display = 'none'; // Hide row if it doesn't match filter
                    }
                }
            }
        });
    </script>
@endsection

@section('script-bottom')
    <!-- Datatables init -->
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
