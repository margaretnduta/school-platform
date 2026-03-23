<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dormitory_beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dormitory_id')->constrained()->onDelete('cascade');
            $table->foreignId('dormitory_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('set null');
            $table->string('bed_number');
            $table->enum('position', ['top', 'bottom']);
            $table->enum('status', ['empty', 'occupied'])->default('empty');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dormitory_beds');
    }
};