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
        Schema::create('homeworks', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Foreign Key -> classes table
            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->onDelete('cascade');

            // Foreign Key -> students table
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');

            // Homework Topic
            $table->string('topic', 100);

            // Homework Status
            $table->string('status', 20);

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
        Schema::dropIfExists('homeworks');
    }
};