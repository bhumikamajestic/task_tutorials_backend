<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONS
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('userId');

            $table->unsignedBigInteger('classId');

            /*
            |--------------------------------------------------------------------------
            | STUDENT FORM DATA
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

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEYS
            |--------------------------------------------------------------------------
            */

            $table->foreign('userId')

                ->references('id')

                ->on('users')

                ->onDelete('cascade');

            $table->foreign('classId')

                ->references('id')

                ->on('classes')

                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | PREVENT DUPLICATE ENROLLMENT
            |--------------------------------------------------------------------------
            */

            $table->unique(['userId', 'classId']);
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
}