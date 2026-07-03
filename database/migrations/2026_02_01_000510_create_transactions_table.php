<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_account_id')->nullable()->index();
            $table->string('external_txn_id')->nullable();
            // Amount in halalas; negative means debit.
            $table->bigInteger('amount_halalas')->default(0);
            $table->enum('direction', ['debit', 'credit']);
            $table->string('category_key')->nullable()->index();
            $table->string('description')->nullable();
            $table->timestamp('booked_at')->index();

            $table->unique(['bank_account_id', 'external_txn_id']);
            $table->index(['user_id', 'booked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
