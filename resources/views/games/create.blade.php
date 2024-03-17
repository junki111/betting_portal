@extends('layouts.main')

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('games.index') }}">Game Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Games</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Create Game</h4>
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
                            <h4 class="header-title mt-0 mb-1">New Game</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('view_games')
                                <a href="{{ route('games.index') }}" class="btn btn-sm btn-soft-primary float-right">
                                    <i class="uil uil-arrow-left"> Back to Games</i>
                                </a>
                            @endcan
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xl-10">
                            <form action="{{ route('games.create') }}" method="post">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="HomeTeam" class="col-1 col-form-label">Home Team</label>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="HomeTeam"
                                            placeholder="Home Team Name" required value="{{ old('home_team') }}"
                                            name="home_team">
                                    </div>
                                    <label for="HomeTeamOdds" class="col-1 col-form-label">Odds</label>
                                    <div class="col-1">
                                        <input type="text" class="form-control" id="HomeTeamOdds" placeholder="Odds"
                                            required value="{{ old('home_team_odds') }}" name="home_team_odds">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="Draw" class="col-1 col-form-label">Draw</label>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="Draw" placeholder="Draw"
                                            required value="draw" name="draw">
                                    </div>
                                    <label for="DrawOdds" class="col-1 col-form-label">Odds</label>
                                    <div class="col-1">
                                        <input type="text" class="form-control" id="DrawOdds" placeholder="Odds"
                                            required value="{{ old('draw_odds') }}" name="draw_odds">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="AwayTeam" class="col-1 col-form-label">Away Team</label>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="AwayTeam"
                                            placeholder="Away Team Name" required value="{{ old('away_team') }}"
                                            name="away_team">
                                    </div>
                                    <label for="AwayTeamOdds" class="col-1 col-form-label">Odds</label>
                                    <div class="col-1">
                                        <input type="text" class="form-control" id="AwayTeamOdds" placeholder="Odds"
                                            required value="{{ old('away_team_odds') }}" name="away_team_odds">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="GameDate" class="col-1 col-form-label">Game Date</label>
                                    <div class="col-3">
                                        <input type="datetime-local" class="form-control" id="GameDate"
                                            placeholder="Game Date" required value="{{ old('game_date') }}"
                                            name="game_date">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="GameType" class="col-1 col-form-label">Game Type</label>
                                    <div class="col-3">
                                        <select name="game_type_id" id="GameType" class="form-group custom-select"
                                            required>
                                            @foreach ($gametypes as $gametype)
                                                <option value="{{ $gametype->id }}">{{ ucwords($gametype->name) }}
                                                </option>
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
