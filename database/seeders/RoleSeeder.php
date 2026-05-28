<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasRole;

class RoleSeeder extends Seeder
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
        | STUDENT ROLE
        |--------------------------------------------------------------------------
        */

        MasRole::create([

            'name' => 'student'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FACULTY ROLE
        |--------------------------------------------------------------------------
        */

        MasRole::create([

            'name' => 'faculty'
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN ROLE
        |--------------------------------------------------------------------------
        */

        MasRole::create([

            'name' => 'admin'
        ]);
    }
}