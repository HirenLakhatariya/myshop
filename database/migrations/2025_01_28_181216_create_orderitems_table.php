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
        Schema::create('orderitems', function (Blueprint $table) {
            $table->id();
            $table->string('order_id'); // Foreign key to the orders table
            $table->unsignedBigInteger('product_id'); // Foreign key to the products table
            $table->integer('quantity'); // Quantity of the product
            $table->decimal('price', 10, 2); // Price of the product at the time of order

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderitems');
    }
};
