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
        Schema::create('analyst_headers', function (Blueprint $table) {
            $table->id();
            $table->json('qualification')->nullable();      // array text
            $table->json('general')->nullable();    // array text
            $table->json('technic')->nullable();    // array text
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->enum('status', ['open', 'submit', 'approve'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyst_headers');
    }
};
