<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('decision_session_id')->nullable()->index();
            $table->bigInteger('amount_halalas')->default(0);
            // SAMA cap: tenor <= 60 months.
            $table->smallInteger('tenor_months')->nullable();
            $table->string('purpose')->nullable();
            $table->foreignId('best_offer_id')->nullable()->index();
            $table->enum('status', ['draft', 'compared', 'decided', 'dismissed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_requests');
    }
};
