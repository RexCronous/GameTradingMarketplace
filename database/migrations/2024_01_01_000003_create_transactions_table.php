<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items', 'id')->cascadeOnDelete();
            $table->foreignId('offer_item_id')->nullable()->constrained('items', 'id')->setOnDelete('set null');
            $table->decimal('offer_amount', 12, 2)->nullable(); // money offered if not trading item
            $table->decimal('total_price', 12, 2)->nullable();
            $table->enum('type', ['buy', 'trade'])->default('buy');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->index(['buyer_id', 'seller_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
