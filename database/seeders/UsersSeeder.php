<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_user = User::create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'email' => 'junki.moturi@gmail.com',
            'msisdn' => '254719448593',
            'password' => Hash::make('test1234'),
            'type' => '1',
            'status' => '1',
        ]);

        $super_user->assignRole(['Superuser']);
    }
}
