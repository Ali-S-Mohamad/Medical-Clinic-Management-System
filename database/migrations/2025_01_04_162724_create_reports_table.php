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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name'); //من الموعد
            $table->string('doctor_name'); //من الموعد
            $table->date('appointment_date'); //من الموعد
            $table->text('medications_names')->nullable();
            $table->text('instructions'); //من الوصفات
            $table->text('details')->nullable(); //من الوصفات
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
