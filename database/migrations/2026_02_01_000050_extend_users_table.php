<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Extend the standard users table with Rashid-specific columns.
     * Additive only: existing columns are not modified.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('name');
            $table->string('role')->default('individual')->index()->after('phone');
            $table->string('national_id_hash')->nullable()->after('role');
            $table->string('residency_type')->nullable()->after('national_id_hash');
            $table->string('status')->default('active')->after('residency_type');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('locale', 8)->default('ar')->after('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropIndex(['role']);
            $table->dropColumn([
                'phone',
                'role',
                'national_id_hash',
                'residency_type',
                'status',
                'phone_verified_at',
                'locale',
                'deleted_at',
            ]);
        });
    }
};
