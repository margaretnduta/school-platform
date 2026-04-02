<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('class');
            $table->enum('term', ['term_1', 'term_2', 'term_3']);
            $table->string('year');
            $table->decimal('marks', 5, 2)->nullable();
            $table->decimal('total_marks', 5, 2)->default(100);
            $table->string('grade')->nullable();
            $table->string('points')->nullable();
            $table->enum('status', ['pass', 'fail'])->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'term', 'year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_records');
    }
};