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
        Schema::create('analyst_bodys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analyst_head_id')->constrained('analyst_headers')->onDelete('cascade');
            $table->string('position')->nullable();
            $table->string('personil')->nullable();
            $table->json('qualification')->nullable();      // array text
            $table->json('general')->nullable();    // array text
            $table->json('technic')->nullable();    // array text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyst_bodys');
    }
};
