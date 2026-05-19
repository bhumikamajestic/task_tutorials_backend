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
        Schema::create('classes', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Foreign Key -> faculty table
            $table->unsignedBigInteger('faculty_id');

            // Foreign Key -> subjects table
            $table->unsignedBigInteger('subject_id');

            // Class Name
            $table->string('name', 20);

            // Meeting Link
            $table->string('class_link', 100);

            // Class Date
            $table->date('class_date');

            // Start Time
            $table->time('start_time');

            // End Time
            $table->time('end_time');

            // created_at & updated_at
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
        Schema::dropIfExists('classes');
    }
};