<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        abort_if(Gate::denies('view_accounts'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->type == 1 || Auth::user()->type == 2) {
            if ($request->has('filter') && $request->filter == 'wins') {
                $accounts = Accounts::where('outcome', 'win')->paginate(10);
                $total_wins = Accounts::where('outcome', 'win')->sum('amount');
                $total_losses = Accounts::where('outcome', 'loss')->sum('amount');
                return view('accounts.index', compact('accounts', 'total_wins', 'total_losses'));
            } else if ($request->has('filter') && $request->filter == 'losses') {
                $accounts = Accounts::where('outcome', 'loss')->paginate(10);
                $total_wins = Accounts::where('outcome', 'win')->sum('amount');
                $total_losses = Accounts::where('outcome', 'loss')->sum('amount');
                return view('accounts.index', compact('accounts', 'total_wins', 'total_losses'));
            } else {
                $accounts = Accounts::paginate(10);
                $total_wins = Accounts::where('outcome', 'win')->sum('amount');
                $total_losses = Accounts::where('outcome', 'loss')->sum('amount');
                return view('accounts.index', compact('accounts', 'total_wins', 'total_losses'));
            }
        } else {
            if ($request->has('filter') && $request->filter == 'wins') {
                $accounts = Accounts::where('outcome', 'win')->where('user_id', Auth::user()->id)->paginate(10);
                $total_wins = Accounts::where('outcome', 'win')->where('user_id', Auth::user()->id)->sum('amount');
                $total_losses = Accounts::where('outcome', 'loss')->where('user_id', Auth::user()->id)->sum('amount');
                
            } else if ($request->has('filter') && $request->filter == 'losses') {
                $accounts = Accounts::where('outcome', 'loss')->where('user_id', Auth::user()->id)->paginate(10);
                $total_wins = Accounts::where('outcome', 'win')->where('user_id', Auth::user()->id)->sum('amount');
                $total_losses = Accounts::where('outcome', 'loss')->where('user_id', Auth::user()->id)->sum('amount');
            } else {
                $accounts = Accounts::where('user_id', Auth::user()->id)->paginate(10);
                $total_wins = Accounts::where('outcome', 'win')->where('user_id', Auth::user()->id)->sum('amount');
                $total_losses = Accounts::where('outcome', 'loss')->where('user_id', Auth::user()->id)->sum('amount');
            }
        }

        return view('accounts.index', compact('accounts', 'total_wins', 'total_losses'));
    }

}
