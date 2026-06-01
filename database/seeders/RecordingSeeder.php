<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recording;

class RecordingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MATHS RECORDINGS
        |--------------------------------------------------------------------------
        */

        Recording::create([
            'class_id' => 1,
            'topic' => 'Algebra Basics',
            'duration' => 45,
            'video_link' => 'https://youtube.com/algebra-basics'
        ]);

        Recording::create([
            'class_id' => 1,
            'topic' => 'Linear Equations',
            'duration' => 30,
            'video_link' => 'https://youtube.com/linear-equations'
        ]);

        /*
        |--------------------------------------------------------------------------
        | ENGLISH RECORDINGS
        |--------------------------------------------------------------------------
        */

        Recording::create([
            'class_id' => 2,
            'topic' => 'Grammar Fundamentals',
            'duration' => 40,
            'video_link' => 'https://youtube.com/grammar-fundamentals'
        ]);

        Recording::create([
            'class_id' => 2,
            'topic' => 'Parts Of Speech',
            'duration' => 35,
            'video_link' => 'https://youtube.com/parts-of-speech'
        ]);
    }
}