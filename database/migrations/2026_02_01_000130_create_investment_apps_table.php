<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_apps', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->enum('type', ['robo_advisor', 'sukuk', 'savings_program']);
            $table->decimal('management_fee', 5, 3)->nullable();
            $table->decimal('target_return', 5, 2)->nullable();
            $table->bigInteger('min_amount_halalas')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_apps');
    }
};
