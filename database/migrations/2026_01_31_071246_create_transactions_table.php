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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Payer (Customer)
            $table->foreignId('worker_id')->constrained('users')->onDelete('cascade'); // Receiver (Worker)
            $table->foreignId('request_id')->nullable()->constrained()->onDelete('set null'); // Linked Job
            $table->decimal('amount', 12, 2);
            $table->string('type')->default('payment'); // payment, payout, refund
            $table->string('status')->default('held'); // held (escrow), released, refunded
            $table->string('payment_method'); // MPESA, TIGOPESA, AIRTEL, HALOPESA
            $table->string('reference')->unique(); // Unique Transaction ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
