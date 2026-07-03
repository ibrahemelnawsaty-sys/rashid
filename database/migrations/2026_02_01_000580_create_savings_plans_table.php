<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('financial_goal_id')->nullable()->index();
            $table->string('alternative_slug')->nullable();
            $table->string('provider_type')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->bigInteger('target_amount_halalas')->default(0);
            $table->bigInteger('monthly_amount_halalas')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'completed', 'paused', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_plans');
    }
};
