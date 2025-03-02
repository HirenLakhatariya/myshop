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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->integer('product_id');
            $table->string('quantity_in_g');
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->integer('number');
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable for guests
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
