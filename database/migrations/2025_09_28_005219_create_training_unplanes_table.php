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
        Schema::create('training_unplanes', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->default('0'); // ID dari API, bukan foreign key
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('workshop_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['open', 'submit', 'approve', 'close', 'reject'])->default('open');
            $table->text('notes')->nullable();
            $table->foreignId('approve_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('instructur', ['internal', 'external']);
            $table->string('name');
            $table->string('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_unplanes');
    }
};
