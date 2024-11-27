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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            // $table->foreignId('role_id')->constrained('role')->cascadeOnDelete();
<<<<<<< HEAD
<<<<<<< HEAD
            $table->boolean('is_patient')->default(true);
=======
            $table->boolean('is_patient')->default(false);
>>>>>>> abfceba8c2e60a4d244f103b93b677bf09633733
=======
            $table->boolean('is_patient')->default(true);

>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};