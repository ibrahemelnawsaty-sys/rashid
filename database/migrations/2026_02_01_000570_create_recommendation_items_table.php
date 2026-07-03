<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recommendation_id')->nullable()->index();
            $table->string('alternative_slug');
            $table->string('provider_type')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedTinyInteger('rank')->default(0);
            $table->bigInteger('projected_cost_halalas')->nullable();
            $table->bigInteger('projected_saving_halalas')->nullable();
            $table->text('reason_ar')->nullable();
            $table->string('cta_route')->nullable();
            $table->timestamps();

            $table->index(['provider_type', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_items');
    }
};
