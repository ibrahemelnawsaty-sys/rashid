<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'open_banking_ais',
                'open_banking_pis',
                'pdpl_processing',
                'marketing',
            ]);
            $table->json('scope')->nullable();
            $table->string('provider_slug')->nullable();
            $table->enum('status', ['granted', 'revoked', 'expired'])->default('granted');
            $table->timestamp('granted_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('revoked_at')->nullable();
            $table->string('ip_at_grant', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consents');
    }
};
