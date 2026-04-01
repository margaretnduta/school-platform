<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['taken', 'not_taken'])->default('taken');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['meal_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('meal_records');
    }
};