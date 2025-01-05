<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('employees')->cascadeOnDelete();
            $table->time('start_time'); 
            $table->time('end_time'); 
            $table->tinyInteger('day_of_week'); // Today (0 for Sunday, 6 for Saturday)
            $table->boolean('is_available')->default(true); // Status of the time period
            $table->integer('slot_duration')->default(30); // Duration of each time slot in minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
