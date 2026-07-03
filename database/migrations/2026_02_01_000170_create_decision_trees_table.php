<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decision_trees', function (Blueprint $table) {
            $table->id();
            $table->string('version')->unique();
            $table->string('name');
            $table->boolean('is_active')->default(false)->index();
            $table->json('definition')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decision_trees');
    }
};
