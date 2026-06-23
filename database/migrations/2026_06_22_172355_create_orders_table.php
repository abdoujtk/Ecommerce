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
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            // restrict: cannot delete product if orders exist
            $table->foreignId('store_id')->constrained()->onDelete('restrict');
            // Denormalized: store_id directly in orders for fast queries
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->text('customer_note')->nullable();
            $table->string('status')->default('pending');
            // pending, confirmed, rejected, delivered
            $table->string('rating_code')->nullable()->unique();
            // Generated when delivered, used for rating link
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
