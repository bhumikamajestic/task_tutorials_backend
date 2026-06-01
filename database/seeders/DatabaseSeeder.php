<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            RoleSeeder::class,

            UserSeeder::class,

            FacultySeeder::class,

            SubjectSeeder::class,

            ClassSeeder::class,

            StudentSeeder::class,

            EnrollmentSeeder::class,
             NoteSeeder::class,
        ]);
    }
}