<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('monthly_income_halalas')->default(0);
            $table->bigInteger('monthly_expenses_halalas')->default(0);
            $table->bigInteger('total_obligations_halalas')->default(0);
            $table->decimal('dti_ratio', 5, 2)->nullable();
            $table->bigInteger('disposable_income_halalas')->default(0);
            $table->bigInteger('emergency_fund_halalas')->default(0);
            $table->enum('risk_band', ['low', 'medium', 'high'])->nullable();
            $table->timestamp('computed_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_profiles');
    }
};
