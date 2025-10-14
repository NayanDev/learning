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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained()->onDelete('cascade');
            $table->foreignId('organizer')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('speaker')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('divisi');
            $table->enum('instructor', ['internal', 'external']);
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
