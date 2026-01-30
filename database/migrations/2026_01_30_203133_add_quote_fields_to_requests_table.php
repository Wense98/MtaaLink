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
        Schema::table('requests', function (Blueprint $table) {
            $table->decimal('price_estimate', 12, 2)->nullable()->after('status');
            $table->text('worker_notes')->nullable()->after('price_estimate');
            $table->timestamp('quoted_at')->nullable()->after('worker_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['price_estimate', 'worker_notes', 'quoted_at']);
        });
    }
};
