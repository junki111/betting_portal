{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.main')

@section('css')
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
@endsection

@section('content')
    @include('flash.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6"></div>
                        <div class="float-right col-lg-6">
                            @can('create_bets')
                                <div class="float-right text-center mt-4">
                                    <button id="proceed-btn" class="btn btn-primary">Proceed to Checkout</button>
                                </div>
                            @endcan
                        </div>
                    </div>
                    @foreach ($gametypes as $gametype)
                        <h1 class="text-center badge-secondary">{{ $gametype->name }}</h1>
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Match Details</th>
                                        <th>Odds</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($games as $game)
                                        @if ($game->game_type_id == $gametype->id)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <div>
                                                            <span>{{ $game->home_team }}<img
                                                                    class="avatar-sm rounded-circle mr-2"
                                                                    src="{{ URL::asset('assets/images/football.png') }}"
                                                                    alt=""></span>
                                                        </div>
                                                        <div>
                                                            <span class="ml-5 mr-5">
                                                                VS
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span><img class="avatar-sm rounded-circle mr-2"
                                                                    src="{{ URL::asset('assets/images/football.png') }}"
                                                                    alt="">{{ $game->away_team }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="game-card row" data-game-id="{{ $game->id }}"
                                                        data-game-match-details="{{ $game->home_team }}. ' VS ' .{{ $game->away_team }}">
                                                        <div class="col-lg-4">
                                                            <div class="team-odd d-flex flex-column"
                                                                data-team="{{ $game->home_team }}"
                                                                data-odd="{{ round($game->home_team_odds, 2) }}">
                                                                <span class=""><span class="">1</span>
                                                                </span>
                                                                <span class=""><span
                                                                        class="">{{ round($game->home_team_odds, 2) }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="team-odd d-flex flex-column"
                                                                data-team="{{ $game->draw }}"
                                                                data-odd="{{ round($game->draw_odds, 2) }}">
                                                                <span class=""><span class="">X</span>
                                                                </span>
                                                                <span class=""><span
                                                                        class="">{{ round($game->draw_odds, 2) }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="team-odd d-flex flex-column"
                                                                data-team="{{ $game->away_team }}"
                                                                data-odd="{{ round($game->away_team_odds, 2) }}">
                                                                <span class=""><span class="">2</span>
                                                                </span>
                                                                <span class=""><span
                                                                        class="">{{ round($game->away_team_odds, 2) }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($game->status == 1)
                                                        <span class="badge badge-warning">Active</span>
                                                    @elseif ($game->status == 2)
                                                        <span class="badge badge-success">Complete</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="betModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Place Bet</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Display selected games' odds and team details -->
                    <div id="gameDetails">
                        <!-- Populated dynamically using JavaScript -->
                    </div>

                    <!-- Bet form -->
                    <form id="betForm" action="{{ route('bets.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="betAmount">Bet Amount:</label>
                            <input type="number" class="form-control" id="betAmount" name="bet_amount" required>
                        </div>
                        <input type="hidden" id="gameIds" name="game_ids" value="game_ids[]">
                        <input type="hidden" id="betTypes" name="bet_types" value="bet_types[]">
                        <input type="hidden" id="betPotentialWinnings" name="bet_potential_winnings" value="">
                        <input type="hidden" id="createdBy" name="created_by" value="{{ Auth::user()->id }}">
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="placeBetBtn">Place Bet</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
@endsection

@section('script')
    <script>
        // Initialize an empty array to store selected games
        let selectedGames = [];
        let selectedTeams = [];
        let selectedOdds = [];

        function openBetModal() {
            // Code to fetch selected games' details and populate the modal
            let modalBody = document.querySelector('#gameDetails');
            modalBody.innerHTML = '';

            // Populate the modal body with the selected data
            for (let i = 0; i < selectedGames.length; i++) {
                let gameDetail = document.createElement('p');
                let lineBreak = document.createElement('br');
                gameDetail.textContent =
                    `Game: ${selectedGames[i].gameMatchDetails}, Team: ${selectedTeams[i]}, Odd: ${selectedOdds[i]}`;
                modalBody.appendChild(gameDetail);
                modalBody.appendChild(lineBreak);
            }

            // Update the hidden input fields with the selected games' details
            let gameIdsInput = document.querySelector('#gameIds');
            let betTypesInput = document.querySelector('#betTypes');

            gameIdsInput.value = selectedGames.map(game => game.gameId).join(',');
            betTypesInput.value = selectedTeams.join(',');

            // Open the modal
            $('#betModal').modal('show');
        }

        // Event listener for Proceed button click
        $('#proceed-btn').click(function() {
            openBetModal();
        });

        // Event listener for Place Bet button click
        $('#placeBetBtn').click(function() {
            // Submit the bet form
            let betPotentialWinningsInput = document.querySelector('#betPotentialWinnings');

            // Calculate the potential winnings by multiplying the selected odds together by the amount
            let betAmount = document.querySelector('#betAmount').value;
            let potentialWinnings = (selectedOdds.reduce((a, b) => a * b, 1) * betAmount).toFixed(2);
            betPotentialWinningsInput.value = potentialWinnings;
            $('#betForm').submit(); // Or you can handle the form submission using AJAX
        });

        // Handle click event on team odds
        document.querySelectorAll('.team-odd').forEach(item => {
            item.addEventListener('click', event => {
                console.log(item.getAttribute('data-team'));
                console.log(item.getAttribute('data-odd'));
                const gameId = item.closest('.game-card').getAttribute('data-game-id');
                const gameMatchDetails = item.closest('.game-card').getAttribute(
                    'data-game-match-details');
                const team = item.getAttribute('data-team');
                const odd = item.getAttribute('data-odd');


                //Toggle selection state
                // if (item.classList.contains('selected')) {
                //     item.classList.remove('selected');
                //     item.classList.remove('badge');
                //     item.classList.remove('badge-primary');
                //     // Remove from selected games list
                //     removeGameFromSelection(gameId, team, odd);
                // } else {
                document.querySelectorAll(`.game-card[data-game-id="${gameId}"] .team-odd.selected`)
                    .forEach(selectedItem => {
                        if (selectedItem !== item) {
                            selectedItem.classList.remove('selected');
                            selectedItem.classList.remove('badge');
                            selectedItem.classList.remove('badge-primary');

                            // Remove from selected games list
                            removeGameFromSelection(gameId, selectedItem.getAttribute('data-team'),
                                selectedItem.getAttribute('data-odd'));
                        }
                    });
                item.classList.add('selected');
                item.classList.add('badge');
                item.classList.add('badge-primary');
                // Add to selected games list
                addGameToSelection(gameId, team, odd, gameMatchDetails);
                console.log(selectedGames);
                console.log(selectedTeams);
                console.log(selectedOdds);
                //}
            });
        });

        // Function to add game to selection
        function addGameToSelection(gameId, team, odd, gameMatchDetails) {
            // Add the selected game to the array
            selectedGames.push({
                gameId,
                gameMatchDetails
            });
            selectedTeams.push(team);
            selectedOdds.push(odd);
        }

        // Function to remove game from selection
        function removeGameFromSelection(gameId, teamId, oddVal) {
            // Find and remove the game from the array
            selectedGames = selectedGames.filter(game => game.gameId !== gameId);
            selectedTeams = selectedTeams.filter(team => team !== teamId);
            selectedOdds = selectedOdds.filter(odd => odd !== oddVal);
        }
    </script>
    <!-- datatable js -->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
@endsection

@section('script-bottom')
    <!-- Datatables init -->
@endsection
