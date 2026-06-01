<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MATHS NOTES
        |--------------------------------------------------------------------------
        */

        Note::create([

            'class_id' => 1,

            'subject_id' => 1,

            'topic' => 'Algebra Basics',

            'file_url' => 'notes/algebra-basics.pdf'
        ]);

        Note::create([

            'class_id' => 1,

            'subject_id' => 1,

            'topic' => 'Linear Equations',

            'file_url' => 'notes/linear-equations.pdf'
        ]);

        /*
        |--------------------------------------------------------------------------
        | ENGLISH NOTES
        |--------------------------------------------------------------------------
        */

        Note::create([

            'class_id' => 2,

            'subject_id' => 2,

            'topic' => 'Grammar Fundamentals',

            'file_url' => 'notes/grammar-fundamentals.pdf'
        ]);

        Note::create([

            'class_id' => 2,

            'subject_id' => 2,

            'topic' => 'Essay Writing',

            'file_url' => 'notes/essay-writing.pdf'
        ]);
    }
}