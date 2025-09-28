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
        Schema::create('training_analysis', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('personil');
            $table->json('qualification')->nullable();      // array text
            $table->json('general_training')->nullable();    // array text
            $table->json('technic_training')->nullable();    // array text
            $table->enum('status', ['open', 'submit', 'approve'])->default('open');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_analysis');
    }
};
