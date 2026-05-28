<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | USER RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignId('userId')

                ->constrained('users')

                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | CLASS RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignId('classId')

                ->constrained('classes')

                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | STUDENT DETAILS
            |--------------------------------------------------------------------------
            */

            $table->date('dob');

            $table->string('address');

            /*
            |--------------------------------------------------------------------------
            | ENROLLMENT STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [

                'pending',

                'approved',

                'rejected'

            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};