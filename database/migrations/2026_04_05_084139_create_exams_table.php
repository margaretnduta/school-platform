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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Mid-Term", "End of Term"
            $table->string('term'); // Term 1, 2, 3
            $table->integer('year')->default(date('Y'));
            $table->string('level'); // e.g., "Form 1", "Form 2", etc.
            $table->string('stream')->nullable(); // A, B, C, etc.
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['planned', 'ongoing', 'completed'])->default('planned');
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
        Schema::dropIfExists('exams');
    }
};
