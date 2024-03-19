<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Bets;
use App\Models\SportsGamesType;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('view_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $games = Game::withTrashed()->paginate(10);

        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('create_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gametypes = SportsGamesType::all();

        return view('games.create', compact('gametypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        abort_if(Gate::denies('create_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'home_team' => ['required'],
            'home_team_odds' => ['required', 'numeric'],
            'away_team' => ['required'],
            'away_team_odds' => ['required', 'numeric'],
            'draw' => ['required'],
            'draw_odds' => ['required', 'numeric'],
            'game_date' => ['required'],
            'game_type_id' => ['required']
        ]);

        
        // Format the game_date before saving
        $gameDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('game_date'))->toDateTimeString();

        $game = Game::create(array_merge($request->except('game_date'), ['game_date' => $gameDate, 'created_by' => Auth::user()->id, 'status' => 1]));

        if ($game) {
            return redirect()->route('games.index')
                ->with('success', 'Game created successfully');
        } else {
            return redirect()->route('games.index')
                ->with('error', 'Game not created');
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
        abort_if(Gate::denies('view_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $game = Game::find($id);

        return view('games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        abort_if(Gate::denies('edit_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $game = Game::find($id);

        $gametypes = SportsGamesType::all();

        return view('games.edit', compact('game', 'gametypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        abort_if(Gate::denies('edit_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'home_team' => ['required'],
            'home_team_odds' => ['required', 'numeric'],
            'away_team' => ['required'],
            'away_team_odds' => ['required', 'numeric'],
            'draw' => ['required'],
            'draw_odds' => ['required', 'numeric'],
            'game_date' => ['required'],
            'game_type_id' => ['required'],
            'status' => 'required|in:1,0'
        ]);

        $game = Game::find($id)->update(array_merge($request->all(), ['created_by' => Auth::user()->id]));

        if ($game) {
            return redirect()->route('games.index')
                ->with('success', 'Game updated successfully');
        } else {
            return redirect()->route('games.index')
                ->with('error', 'Game not updated');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        abort_if(Gate::denies('delete_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $game = Game::withTrashed()->find($id);

        if ($game->trashed()) {
            return redirect()->route('games.index')->with('error', 'Game already soft-deleted');
        }

        if ($game->status == 2) {
            return redirect()->route('games.index')->with('error', 'Game already completed. Cannot be soft-deleted');
        }

        $statusUpdate = Game::where('id', $id)->update(['status' => 0, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            // cancel bets associated with the game
            $bets = Bets::whereRaw("CHARINDEX(?, game_id) > 0", [strval($game->id)])->where('status', '=', 1)->get();
            foreach($bets as $bet) {
                $bet->status = 0;
                $bet->save();
            }
            $game->delete();
            return redirect()->route('games.index')->with('success', 'Game soft-deleted successfully');
        } else {
            return redirect()->route('games.index')->with('error', 'Game soft-deletion failed');
        }
    }

    /**
     * Restores the specified resource to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id) {
        //
        abort_if(Gate::denies('delete_games'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $game = Game::withTrashed()->find($id);

        if (!$game->trashed()) {
            return redirect()->route('games.index')->with('error', 'Game not soft-deleted');
        }

        $statusUpdate = Game::withTrashed()->where('id', $id)->update(['status' => 1, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            $bets = Bets::whereRaw("CHARINDEX(?, game_id) > 0", [strval($game->id)])->where('status', '=', 0)->get();
            foreach($bets as $bet) {
                $bet->status = 1;
                $bet->save();
            }
            $game->restore();
            return redirect()->route('games.index')->with('success', 'Game restored successfully');
        } else {
            return redirect()->route('games.index')->with('error', 'Game restored failed');
        }
    }
}
