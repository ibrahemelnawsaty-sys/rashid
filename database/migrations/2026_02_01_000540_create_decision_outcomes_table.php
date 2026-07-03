<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decision_outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decision_session_id')->nullable()->index();
            $table->enum('verdict', ['avoid_borrowing', 'rationalize_borrowing']);
            $table->decimal('affordability_score', 5, 2)->nullable();
            $table->json('recommended_alternative_slugs')->nullable();
            $table->decimal('cheapest_apr', 6, 3)->nullable();
            $table->text('rationale_ar')->nullable();
            $table->timestamps();

            $table->unique('decision_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decision_outcomes');
    }
};
