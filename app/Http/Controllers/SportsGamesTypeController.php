<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportsGamesType;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SportsGamesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('view_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gametypes = SportsGamesType::withTrashed()->paginate(10);

        return view('gametypes.index', compact('gametypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('create_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('gametypes.create');
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
        abort_if(Gate::denies('create_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => ['required'],
            'description' => ['required']
        ]);

        $gametype = SportsGamesType::create(array_merge($request->all(), ['created_by' => Auth::user()->id, 'status' => 1]));

        if ($gametype) {
            return redirect()->route('gametypes.index')
                ->with('success', 'Game type created successfully');
        } else {
            return redirect()->route('gametypes.index')
                ->with('error', 'Game type not created');
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
        abort_if(Gate::denies('view_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gametype = SportsGamesType::find($id);

        return view('gametypes.show', compact('gametype'));
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
        abort_if(Gate::denies('edit_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gametype = SportsGamesType::find($id);

        return view('gametypes.edit', compact('gametype'));
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
        abort_if(Gate::denies('edit_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name' => ['required'],
            'description' => ['required']
        ]);

        $gametype = SportsGamesType::find($id);

        $gametype->name = $request->name;
        $gametype->description = $request->description;
        $gametype->updated_by = Auth::user()->id;

        if ($gametype->save()) {
            return redirect()->route('gametypes.index')
                ->with('success', 'Game type updated successfully');
        } else {
            return redirect()->route('gametypes.index')
                ->with('error', 'Game type not updated');
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
        abort_if(Gate::denies('delete_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gametype = SportsGamesType::find($id);

        $statusUpdate = SportsGamesType::where('id', $id)->update(['status' => 0, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            $gametype->delete();
            return redirect()->route('gametypes.index')
                ->with('success', 'Game type soft-deleted successfully');
        } else {
            return redirect()->route('gametypes.index')
                ->with('error', 'Game type not soft-deleted');
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
        abort_if(Gate::denies('restore_sports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gametype = SportsGamesType::withTrashed()->find($id);

        if (!$gametype->trashed()) {
            return redirect()->route('gametypes.index')->with('error', 'Game Type not soft-deleted');
        }

        $statusUpdate = SportsGamesType::withTrashed()->where('id', $id)->update(['status' => 1, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            $gametype->restore();
            return redirect()->route('gametypes.index')
                ->with('success', 'Game type restored successfully');
        } else {
            return redirect()->route('gametypes.index')
                ->with('error', 'Game type not restored');
        }
    }
}
