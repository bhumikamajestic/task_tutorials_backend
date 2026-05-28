<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
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
        | 10th Maths
        |--------------------------------------------------------------------------
        */

        ClassModel::create([

            'name' => '10th',

            'subjectId' => 1,

            'facultyId' => 1
        ]);

        /*
        |--------------------------------------------------------------------------
        | 10th English
        |--------------------------------------------------------------------------
        */

        ClassModel::create([

            'name' => '10th',

            'subjectId' => 2,

            'facultyId' => 1
        ]);

        /*
        |--------------------------------------------------------------------------
        | 10th Science
        |--------------------------------------------------------------------------
        */

        ClassModel::create([

            'name' => '10th',

            'subjectId' => 3,

            'facultyId' => 1
        ]);
    }
}