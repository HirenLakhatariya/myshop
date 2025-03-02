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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // Custom order ID
            $table->unsignedBigInteger('user_id')->nullable(); // User who placed the order
            $table->decimal('total_amount', 10, 2); // Total amount of the order
            $table->string('status')->default('pending'); // Order status (e.g., pending, completed, cancelled)
            $table->string('number'); // Order status (e.g., pending, completed, cancelled)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
