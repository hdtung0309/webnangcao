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
        Schema::create('students', function (Blueprint $table) {
            $table->id('id');
            $table->string('full_name');
            $table->enum('gender', ['male', 'female']); 
            $table->date('birth_date'); 
            $table->string('hometown'); 
            $table->string('email')->unique();
            $table->string('phone_number'); 
            $table->string('username')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('class_id')->constrained('classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
