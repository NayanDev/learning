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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained(); // event_id nullable
            $table->foreignId('test_employee_id')->nullable()->constrained('training_new_employees'); // test_employee_id, harus ada relasi dengan tabel lainnya
            $table->text('question_text'); // Kolom untuk pertanyaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
