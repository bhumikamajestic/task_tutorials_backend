<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN USER
        |--------------------------------------------------------------------------
        */

        User::create([

            'roleId' => 3,

            'name' => 'Admin',

            'email' => 'admin@gmail.com',

            'password' => Hash::make('password'),

            'phone_no' => '9999999999'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FACULTY USER
        |--------------------------------------------------------------------------
        */

        User::create([

            'roleId' => 2,

            'name' => 'Ramesh',

            'email' => 'faculty@gmail.com',

            'password' => Hash::make('password'),

            'phone_no' => '8888888888'
        ]);

        /*
        |--------------------------------------------------------------------------
        | STUDENT USER
        |--------------------------------------------------------------------------
        */

        User::create([

            'roleId' => 1,

            'name' => 'Daksh',

            'email' => 'student@gmail.com',

            'password' => Hash::make('password'),

            'phone_no' => '7777777777'
        ]);
    }
}