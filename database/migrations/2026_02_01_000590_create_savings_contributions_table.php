<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('savings_plan_id')->nullable()->index();
            $table->bigInteger('amount_halalas')->default(0);
            $table->enum('source', ['manual', 'pis_auto'])->default('manual');
            $table->timestamp('contributed_at')->nullable()->index();
            $table->enum('status', ['scheduled', 'completed', 'failed'])->default('completed');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_contributions');
    }
};
