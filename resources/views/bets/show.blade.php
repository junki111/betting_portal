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
                    <li class="breadcrumb-item"><a href="{{ route('bets.index') }}">Bet Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bet</li>
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
                            <h4 class="header-title mt-0 mb-1">View Bet</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('view_bets')
                                <a href="javascript:void(0)" onclick="history.back()"
                                    class="btn btn-sm btn-soft-primary float-right" rel="tooltip" data-placement="top"
                                    title="Back to Bets">
                                    <i class="uil uil-arrow-left"> Back to Bets</i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-10">
                        <div class="matches">
                            <h4 class="badge badge-secondary">Matches</h4>
                            @foreach ($games as $game)
                                <div class="form-group row mb-3 align-items-center">
                                    <label for="match_details" class="col-2 col-form-label"><span>Match
                                            Details</span></label>
                                    <div class="d-flex" id="match_details">
                                        <div>
                                            <span
                                                class="{{ in_array($game->home_team, $bet_types) ? 'badge badge-primary' : '' }}">{{ $game->home_team }}</span>
                                            <img class="avatar-sm rounded-circle mr-2"
                                                src="{{ URL::asset('assets/images/football.png') }}" alt="">
                                        </div>
                                        <div>
                                            <span
                                                class="{{ in_array($game->draw, $bet_types) ? 'badge badge-primary' : '' }} ml-5 mr-5">
                                                VS
                                            </span>
                                        </div>
                                        <div>
                                            <img class="avatar-sm rounded-circle mr-2"
                                                src="{{ URL::asset('assets/images/football.png') }}" alt="">
                                            <span
                                                class="{{ in_array($game->away_team, $bet_types) ? 'badge badge-primary' : '' }}">{{ $game->away_team }}</span>
                                        </div>
                                        <div class="ml-5">
                                            <span class="badge badge-success"
                                                id="matchWinner">{{ $game->game_result }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="details">
                            <h4 class="badge badge-secondary">Bet Details</h4>
                            <div class="form-group row mb-3 align-items-center">
                                <label for="bet_amount" class="col-2 col-form-label"><span>Bet
                                        Amount</span></label>
                                <div class="col-2">
                                    <span id="bet_amount">{{ round($bet->bet_amount, 2) }}Ksh</span>
                                </div>
                            </div>
                            <div class="form-group row mb-3 align-items-center">
                                <label for="bet_potential" class="col-2 col-form-label"><span>Potential
                                        Winnings</span></label>
                                <div class="col-4">
                                    <span id="bet_potential">{{ round($bet->bet_potential_winnings, 2) }}Ksh</span>
                                </div>
                            </div>
                            <div class="form-group row mb-3 align-items-center">
                                <label for="result" class="col-2 col-form-label"><span
                                        class="badge badge-secondary">Result</span></label>
                                <div class="col-4">
                                    @if ($bet->result == 'win')
                                        <span class="badge badge-success" id="result">{{ $bet->result }}</span>
                                    @elseif ($bet->result == 'loss')
                                        <span class="badge badge-danger" id="result">{{ $bet->result }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
