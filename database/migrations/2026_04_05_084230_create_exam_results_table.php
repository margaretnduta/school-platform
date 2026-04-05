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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->string('subject');
            $table->integer('marks_obtained')->nullable();
            $table->integer('total_marks')->default(100);
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('grade')->nullable(); // A, B, C, D, E, F
            $table->text('comments')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'exam_id', 'subject']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_results');
    }
};
