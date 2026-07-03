<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternative_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->nullable()->index();
            // Polymorphic provider (banks, finance_companies, government_programs, ...).
            $table->string('provider_type');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['provider_type', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternative_providers');
    }
};
