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
                    <li class="breadcrumb-item"><a href="{{ route('games.index') }}">Game Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Game</li>
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
                            <h4 class="header-title mt-0 mb-1">View Game</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('view_games')
                                <a href="{{ route('games.index') }}" class="btn btn-sm btn-soft-primary float-right"
                                    rel="tooltip" data-placement="top" title="Back to Games">
                                    <i class="uil uil-arrow-left"> Back to Games</i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-10">
                        <div class="form-group row mb-3">
                            <label for="home_team" class="col-1 col-form-label"><span class="badge badge-dark">Home Team
                                    Name</span></label>
                            <div class="col-3">
                                <h5 id="home_team">{{ $game->home_team }}</h5>
                            </div>
                            <label for="home_team_odds" class="col-1 col-form-label"><span class="badge badge-dark">Odds
                                </span></label>
                            <div class="col-1">
                                <h5 id="home_team_odds">{{ round($game->home_team_odds, 2) }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="draw" class="col-1 col-form-label"><span class="badge badge-dark">Draw
                                </span></label>
                            <div class="col-3">
                            </div>
                            <label for="draw_odds" class="col-1 col-form-label"><span class="badge badge-dark">Odds
                                </span></label>
                            <div class="col-1">
                                <h5 id="draw_odds">{{ round($game->draw_odds, 2) }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="away_team" class="col-1 col-form-label"><span class="badge badge-dark">Away Team
                                    Name</span></label>
                            <div class="col-3">
                                <h5 id="away_team">{{ $game->away_team }}</h5>
                            </div>
                            <label for="away_team_odds" class="col-1 col-form-label"><span class="badge badge-dark">Odds
                                </span></label>
                            <div class="col-1">
                                <h5 id="away_team_odds">{{ round($game->away_team_odds, 2) }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="game_date" class="col-1 col-form-label"><span class="badge badge-dark">Game
                                    Date</span></label>
                            <div class="col-2">
                                <h5 id="game_date">{{ $game->game_date }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="created_by" class="col-1 col-form-label"><span class="badge badge-dark">Created
                                    By</span></label>
                            <div class="col-4">
                                <h5 id="created_by">{{ user_name($game->created_by) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
