<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Game;
use App\Models\SportsGamesType;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return (Auth::user()) ? redirect()->route('dashboard') : $this->login();

    }

    public function login()
    {
        // logout_all_guards();

        return view('login-registration');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        //
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
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
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'msisdn' => ['required', 'string', 'max:12', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'msisdn' => $request->msisdn,
            'password' => Hash::make($request->password),
            'type' => '3',
            'status' => '1',
        ]);

        if ($user) {
            $user->assignRole([role_name($user->type)]);

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('dashboard');
        } else {
            flash('User registration failed')->error();
            return back()->with('error', 'User registration failed!');
        }
    }

    public function dashboard()
    {
        if(Auth::check())
        {
            $games = Game::where('status', '!=', 2)->paginate(10);
            $gametypes = SportsGamesType::all();

            return view('dashboard', compact('games', 'gametypes'));
        } else {
            return redirect()->route('login')
                ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
        }
        
    } 

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    } 
}
