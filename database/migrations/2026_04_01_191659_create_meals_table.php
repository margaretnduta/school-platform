<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('session', ['breakfast', 'lunch', 'dinner']);
            $table->string('class')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['date', 'session', 'class']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('meals');
    }
};