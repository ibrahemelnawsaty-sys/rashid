<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->bigInteger('target_amount_halalas')->default(0);
            $table->bigInteger('saved_amount_halalas')->default(0);
            $table->date('target_date')->nullable();
            $table->unsignedTinyInteger('priority')->default(0);
            $table->enum('status', ['active', 'achieved', 'paused'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
    }
};
