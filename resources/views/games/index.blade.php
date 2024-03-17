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
                    <li class="breadcrumb-item active" aria-current="page"><a href="">Game Management</a></li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Games</h4>
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
                            <h4 class="header-title mt-0 mb-4">Game Management</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('create_games')
                                <a href="{{ route('games.create') }}" class="btn btn-sm btn-soft-primary float-right  mr-2"
                                    data-toggle="tooltip" data-placement="top" title="Add User">
                                    <i class="uil uil-plus"> Add Game</i>
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Home Team</th>
                                    <th>Draw</th>
                                    <th>Away Team</th>
                                    <th>Game Date</th>
                                    <th>Game Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($games as $game)
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <div class="d-flex flex-column text-center">
                                                <span class="badge"><span
                                                        class="badge-pill badge-danger mb-1">{{ $game->home_team }}</span></span>
                                                <span>{{ round($game->home_team_odds, 2) }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column text-center">
                                                <span class="badge"><span
                                                        class="badge-pill badge-light mb-1">{{ $game->draw }}</span></span>
                                                <span>{{ round($game->draw_odds, 2) }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column text-center">
                                                <span class="badge"><span
                                                        class="badge-pill badge-info mb-1">{{ $game->away_team }}</span></span>
                                                <span>{{ round($game->away_team_odds, 2) }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $game->game_date }}</td>
                                        <td class="align-middle">{{ game_type_name($game->game_type_id) }}</td>
                                        <td class="align-middle">
                                            @if ($game->status == 1)
                                                <span class="badge badge-warning">Active</span>
                                            @elseif ($game->status == 2)
                                                <span class="badge badge-success">Complete</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @can('view_games')
                                                <a href="{{ route('games.show', $game->id) }}" title="View Game"
                                                    class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                    data-placement="top"><i class="uil uil-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit_games')
                                                <a href="{{ route('games.edit', $game->id) }}"
                                                    class="btn btn-sm btn-soft-primary" data-toggle="tooltip"
                                                    data-placement="top" title="Edit Game">
                                                    <i class="uil uil-pen"></i>
                                                </a>
                                            @endcan
                                            @can('delete_games')
                                                <form id="delete-game-{{ $game->id }}"
                                                    action="{{ route('games.destroy', $game->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Soft-Delete Game"
                                                        onclick="return confirm('Are you sure you want to delete this game?');">
                                                        <i class="uil uil-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('restore_games')
                                                <form id="delete-game-{{ $game->id }}"
                                                    action="{{ route('games.restore', $game->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-soft-success"
                                                        data-toggle="tooltip" data-placement="top" title="Restore Game"
                                                        onclick="return confirm('Are you sure you want to restore this game?');">
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
