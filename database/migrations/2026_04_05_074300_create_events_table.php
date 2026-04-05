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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('description');
            $table->text('detailed_description')->nullable();
            $table->dateTime('event_date');
            $table->string('location')->nullable();
            $table->string('organizer')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->integer('max_participants')->nullable();
            $table->integer('registered_participants')->default(0);
            $table->string('category')->nullable(); // e.g., 'Sports', 'Academic', 'Cultural', 'Ceremony'
            $table->boolean('is_public')->default(true);
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
        Schema::dropIfExists('events');
    }
};
