<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        $permissions = [
            'super_user' => 'Has all permissions',
            'view_users' => 'View user information',
            'delete_users' => 'Soft delete users',
            'restore_users' => 'Restore soft deleted users',
            'edit_users' => 'Edit user information',
            'create_users' => 'Create new users',
            'access_management' => 'Grant or revoke admin right and super user permission',
            'view_roles' => 'View roles',
            'create_roles' => 'Create roles',
            'edit_roles' => 'Edit roles',
            'delete_roles' => 'Soft delete roles',
            'restore_roles' => 'Restore soft deleted roles',
            'view_permissions' => 'View permissions',
            'view_sports' => 'View sports games',  
            'create_sports' => 'Create sports games',
            'edit_sports' => 'Edit sports games',
            'delete_sports' => 'Soft delete sports games',
            'restore_sports' => 'Restore soft deleted sports games',
            'view_bets' => 'View bets',
            'create_bets' => 'Create bets',
            'edit_bets' => 'Edit bets',
            'delete_bets' => 'Cancel bets',
            'restore_bets' => 'Restore soft deleted bets',
            'view_games' => 'View games',
            'create_games' => 'Create games',
            'edit_games' => 'Edit games',
            'delete_games' => 'Soft delete games',
            'restore_games' => 'Restore soft deleted games',
            'view_accounts' => 'View accounts',
            'configurations' => 'Configure the roles and permissions of the application',
        ];

        foreach ($permissions as $permission => $description) {
            Permission::updateOrCreate(['name' => $permission],['name' => $permission, 'description' => $description]);
        }

        $role_name = 'Superuser';
        $role_desc = 'Has all permissions';
        $role = Role::updateOrCreate(['name' => $role_name], ['name' => $role_name, 'description' => $role_desc]);
        $superuser_permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($superuser_permissions);

        ###########################################################################################################

        $role_name = 'Admin';
        $role_desc = 'Has all permissions except super_user, access_management and edit sports';
        $role = Role::updateOrCreate(['name' => $role_name], ['name' => $role_name, 'description' => $role_desc]);
        $admin_permissions = Permission::where('name', '!=', 'super_user')
            ->where('name', '!=', 'access_management')
            ->where('name', '!=', 'edit_sports')
            ->pluck('id', 'id')->all();
        $role->syncPermissions($admin_permissions);

        ###########################################################################################################

        $role_name = 'Frontend User';
        $role_desc = 'Can view sports games and place bets';
        $role = Role::updateOrCreate(['name' => $role_name], ['name' => $role_name, 'description' => $role_desc]);
        $frontend_user_permissions = ['view_sports', 'create_bets', 'view_bets', 'edit_bets', 'delete_bets', 'view_users', 'edit_users', 'view_sports', 'view_accounts'];
        $frontend_user_permissions = Permission::whereIn('name', $frontend_user_permissions)->pluck('id', 'id')->all();
        $role->syncPermissions($frontend_user_permissions);

        ###########################################################################################################

    }
}
