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
        Schema::create('recordings', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Foreign Key -> classes table
            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->onDelete('cascade');

            // Recording Topic
            $table->string('topic', 100);

            // Duration in minutes
            $table->integer('duration');

            // Video Link
            $table->string('video_link', 100);

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
        Schema::dropIfExists('recordings');
    }
};