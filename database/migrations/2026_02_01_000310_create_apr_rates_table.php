<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apr_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_product_id')->nullable()->index();
            $table->decimal('apr_min', 6, 3)->nullable();
            $table->decimal('apr_max', 6, 3)->nullable();
            $table->decimal('flat_rate', 6, 3)->nullable();
            $table->decimal('return_rate', 6, 3)->nullable();
            $table->bigInteger('admin_fee_halalas')->default(0);
            $table->string('admin_fee_cap_note')->nullable();
            $table->bigInteger('min_amount_halalas')->nullable();
            $table->bigInteger('max_amount_halalas')->nullable();
            $table->smallInteger('min_tenor_months')->nullable();
            $table->smallInteger('max_tenor_months')->nullable();
            $table->date('effective_from')->index();
            $table->date('effective_to')->nullable();
            $table->string('source')->nullable();
            // References users.id (a financial_analyst who verified the rate).
            $table->foreignId('verified_by')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apr_rates');
    }
};
