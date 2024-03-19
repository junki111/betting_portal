<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use app\Models\User;
use App\Models\Bets;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use \Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('view_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($user->type == 1 || $user->type == 2) {
            $users = User::withTrashed()->paginate(10);
            return view('users.index', compact('users'));
        } else {
            $users = User::where('id', $user->id)->first();
            return redirect()->route('users.show', $users->id);
        }
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('create_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();

        return view('users.create', compact('roles'));
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
        abort_if(Gate::denies('create_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'msisdn' => 'required|max:12',
            'email' => 'required|email|unique:users,email',
            'type' => 'required',
        ]);
        // generate random password
        $password = Str::random(8);

        $user = User::create(array_merge($request->all(), ['password' => Hash::make($password), 'status' => 1, 'created_by' => Auth::user()->id]));

        if ($user) {
            $role = role_name($request->type);

            $user->assignRole($role);

            // send email to user with password
            Mail::to($user->email, $user->first_name)->queue(new WelcomeEmail($user, $password));
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } else {
            return redirect()->route('users.index')->with('error', 'User creation failed');
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
        abort_if(Gate::denies('view_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find($id);

        // get user bets
        $bets = Bets::withTrashed()->where('user_id', $user->id)->paginate(10);

        return view('users.show', compact('user', 'bets'));

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
        abort_if(Gate::denies('edit_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find($id);
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
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
        abort_if(Gate::denies('edit_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'msisdn' => 'required|min:12',
            'email' => 'required',
        ]);

        $user = User::find($id);

        $email = $request->get('email');
        $confirmEmail = User::where('email', $email)->where('id', '!=', $user->id)->count();

        if ($confirmEmail) {
            flash()->info($email . ' belongs to another user');
            return redirect()->back();
        }

        $user->update(array_merge($request->all(), ['updated_by' => Auth::user()->id]));
        
        if ($user) {
            if(!$request->role) {
                $role = role_name($user->type);
            } else {
                $role = role_name($request->role);
            }

            $user->syncRoles($role);

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } else {
            return redirect()->route('users.index')->with('error', 'User update failed');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        abort_if(Gate::denies('delete_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find($id);

        $statusUpdate = User::where('id', $id)->update(['status' => 0, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            // cancel all the bets the user made
            $bets = Bets::where('user_id', $id)->where('status', 1)->get();
            foreach($bets as $bet) {
                $bet->status = 0;
                $bet->save();
            }

            $user->delete();
            return redirect()->route('users.index')->with('success', 'User soft-deleted successfully');
        } else {
            return redirect()->route('users.index')->with('error', 'User soft-deletion failed');
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
        abort_if(Gate::denies('delete_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::withTrashed()->find($id);

        if (!$user->trashed()) {
            return redirect()->route('users.index')->with('error', 'User not soft-deleted');
        }

        $statusUpdate = User::withTrashed()->where('id', $id)->update(['status' => 1, 'updated_by' => Auth::user()->id]);

        if ($statusUpdate) {
            $bets = Bets::where('user_id', $id)->where('status', 0)->get();
            foreach($bets as $bet) {
                $bet->status = 1;
                $bet->save();
            }
            $user->restore();
            return redirect()->route('users.index')->with('success', 'User restored successfully');
        } else {
            return redirect()->route('users.index')->with('error', 'User restored failed');
        }
    }
}
