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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // Mengacu pada tabel lain, bisa disesuaikan dengan relasi yang ada
            $table->text('content'); // Kolom untuk konten pertanyaan
            $table->integer('point'); // Kolom untuk nilai poin, bisa juga menggunakan smallInteger() jika ingin nilai yang lebih kecil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
