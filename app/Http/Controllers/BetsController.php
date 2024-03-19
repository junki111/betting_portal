<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Bets;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('view_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($user->type != 3) {
            $bets = Bets::withTrashed()->paginate(10);

            return view('bets.index', compact('bets'));
        } else {
            $bets = Bets::withTrashed()->where('user_id', $user->id)->paginate(10);
            return view('bets.index', compact('bets'));
        }
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    //     abort_if(Gate::denies('create_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $user = Auth::user();
    //     $games = Game::all();

    //     return view('bets.create', compact('user', 'games'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        abort_if(Gate::denies('create_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'created_by' => 'required',
            'game_ids' => 'required',
            'bet_types' => 'required',
            'bet_amount' => 'required: numeric',
            'bet_potential_winnings' => 'required: numeric',
        ]);

        $selected_games = explode(",", $request->game_ids);
        // $selected_teams = explode(",", $request->bet_types);

        foreach ($selected_games as $key => $value) {
            $game = Game::find($value);
            if(!$game) {
                return redirect()->route('bets.index')
                    ->with('error', 'One or more game changes occured. Please place your bet again.');
            }
        }
        // $game = Game::find($request->game_id);

        // if ($request->bet_type == 'home_team') {
        //     $bet_potential_winnings = $request->bet_amount * $game->home_team_odds;
        // } elseif ($request->bet_type == 'away_team') {
        //     $bet_potential_winnings = $request->bet_amount * $game->away_team_odds;
        // } elseif ($request->bet_type == 'draw') {
        //     $bet_potential_winnings = $request->bet_amount * $game->draw_odds;
        // }

        $bet = Bets::create(array_merge($request->all(), ['game_id' => $request->game_ids, 'bet_type' => $request->bet_types, 'status' => 1, 'user_id' => Auth::user()->id]));

        if ($bet) {
            return redirect()->route('dashboard')
                ->with('success', 'Bet placed successfully');
        } else {
            return redirect()->route('dashboard')
                ->with('error', 'Bet not placed. Please try again.');
        }
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        abort_if(Gate::denies('view_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bet = Bets::withTrashed()->find($id);

        $gamesArray = explode(",", $bet->game_id);
        $bet_types = explode(",", $bet->bet_type);
        
        $games = Game::whereIn('id', $gamesArray)->get();

        return view('bets.show', compact('bet', 'games', 'bet_types'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    //     abort_if(Gate::denies('edit_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $bet = Bets::withTrashed()->find($id);

    //     return view('bets.edit', compact('bet'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    //     abort_if(Gate::denies('edit_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $request->validate([
    //         'user_id' => 'required',
    //         'game_id' => 'required',
    //         'bet_type' => 'required',
    //         'bet_amount' => 'required: numeric',
    //         'status' => 'required: numeric',
    //     ]);

    //     $game = Game::find($request->game_id);
    //     $bet_potential_winnings = 0;

    //     if ($request->bet_type == 'home_team') {
    //         $bet_potential_winnings = $request->bet_amount * $game->home_team_odds;
    //     } elseif ($request->bet_type == 'away_team') {
    //         $bet_potential_winnings = $request->bet_amount * $game->away_team_odds;
    //     } elseif ($request->bet_type == 'draw') {
    //         $bet_potential_winnings = $request->bet_amount * $game->draw_odds;
    //     }

    //     $bet = Bets::find($id);
    //     $bet->user_id = $request->user_id;
    //     $bet->game_id = $request->game_id;
    //     $bet->bet_type = $request->bet_type;
    //     $bet->bet_amount = $request->bet_amount;
    //     $bet->bet_potential_winnings = round($bet_potential_winnings, 2);
    //     $bet->status = 1;
    //     $bet->created_by = $request->user_id;

    //     if ($bet->save()) {
    //         return redirect()->route('bets.index')
    //             ->with('success', 'Bet updated successfully');
    //     } else {
    //         return redirect()->route('bets.index')
    //             ->with('error', 'Bet not updated');
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        abort_if(Gate::denies('delete_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bet = Bets::withTrashed()->find($id);

        if ($bet->trashed()) {
            return redirect()->route('bets.index')->with('error', 'Bet already cancelled.');
        }

        if ($bet->status == 2 || $bet->status == 3){
            return redirect()->route('bets.index')->with('error', 'Bet already in progress or completed. Cannot cancel.');
        }

        $statusUpdate = Bets::where('id', $id)->update(['status' => 0, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            $bet->delete();
            return redirect()->route('bets.index')->with('success', 'Bet cancelled successfully');
        } else {
            return redirect()->route('bets.index')->with('error', 'Bet cancellation failed');
        }
    }

    /**
     * Restores the specified resource to storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        //
        abort_if(Gate::denies('restore_bets'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bet = Bets::withTrashed()->find($id);

        if (!$bet->trashed()) {
            return redirect()->route('bets.index')->with('error', 'Bet not soft-deleted');
        }

        $statusUpdate = Bets::withTrashed()->where('id', $id)->update(['status' => 1, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            $bet->restore();
            return redirect()->route('bets.index')->with('success', 'Bet restored successfully');
        } else {
            return redirect()->route('bets.index')->with('error', 'Bet restored failed');
        }
    }
}
