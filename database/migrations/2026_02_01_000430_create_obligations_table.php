<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obligations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('creditor_type', ['bank', 'finance_company', 'bnpl', 'other']);
            $table->string('creditor_name')->nullable();
            $table->bigInteger('principal_halalas')->default(0);
            $table->bigInteger('remaining_halalas')->default(0);
            $table->bigInteger('monthly_installment_halalas')->default(0);
            $table->decimal('apr', 6, 3)->nullable();
            $table->smallInteger('months_remaining')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obligations');
    }
};
