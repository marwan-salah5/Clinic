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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('national_id')->unique()->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->text('address')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('allergies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
