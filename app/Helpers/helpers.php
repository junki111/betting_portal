<?php

use \Spatie\Permission\Models\Role;
use App\Models\SportsGamesType;
use App\Models\User;


if (!function_exists('role_name')) {

    function role_name($id)
    {
        $name = Role::where('id', $id)->first()->name;

        if ($name == null) {
            return 'Role not found';
        }

        return $name;
    }
}

if (!function_exists('game_type_name')) {

    function game_type_name($id)
    {
        $name = SportsGamesType::where('id', $id)->first()->name;

        if ($name == null) {
            return 'Sports game type not found';
        }

        return $name;
    }
}

if (!function_exists('user_name')) {

    function user_name($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        $name = $user->first_name . ' ' . $user->last_name;

        if ($name == null) {
            return 'User name not found';
        }

        return $name;
    }
}

if (!function_exists('logout_all_guards')) {
    
    function logout_all_guards()
    {
        // Log out the user from all guards
        foreach (config('auth.guards') as $guard => $guardConfig) {
            auth()->guard($guard)->logout();
        }
    }
}