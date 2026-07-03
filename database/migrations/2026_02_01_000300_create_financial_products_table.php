<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_products', function (Blueprint $table) {
            $table->id();
            // Polymorphic provider (banks, finance_companies, insurance_companies, ...).
            $table->string('provider_type');
            $table->unsignedBigInteger('provider_id');
            $table->string('name_ar');
            $table->enum('product_type', [
                'personal_finance',
                'credit_card',
                'bnpl',
                'sukuk',
                'savings',
                'takaful',
            ]);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->index(['provider_type', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_products');
    }
};
