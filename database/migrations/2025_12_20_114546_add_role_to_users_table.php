<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Roles: admin, customer, worker
            $table->string('role')->default('customer')->index();
            // Contact & verification
            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            // Worker verification badge (admin approves)
            $table->boolean('is_verified')->default(false)->comment('worker profile verified by admin');
            // Optional avatar
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'phone_verified_at', 'is_verified', 'avatar']);
        });
    }
};
