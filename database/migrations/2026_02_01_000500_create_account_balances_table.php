<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->nullable()->index();
            $table->bigInteger('balance_halalas')->default(0);
            $table->bigInteger('available_halalas')->nullable();
            $table->timestamp('captured_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_balances');
    }
};
