<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create([

            'name' => 'Maths'
        ]);

        Subject::create([

            'name' => 'English'
        ]);

        Subject::create([

            'name' => 'Science'
        ]);
    }
}