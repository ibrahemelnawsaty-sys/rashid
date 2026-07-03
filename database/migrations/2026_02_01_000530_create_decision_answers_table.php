<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decision_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decision_session_id')->nullable()->index();
            $table->string('node_key');
            $table->json('answer')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decision_answers');
    }
};
