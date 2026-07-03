<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('connection_id')->nullable()->index();
            $table->foreignId('bank_id')->nullable()->index();
            $table->string('external_account_id')->nullable();
            $table->string('iban_masked')->nullable();
            $table->enum('account_type', ['current', 'savings', 'credit_card'])->default('current');
            $table->string('currency', 3)->default('SAR');
            $table->boolean('is_manual')->default(false);
            $table->timestamps();

            $table->unique(['connection_id', 'external_account_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
