<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();     // item being offered on
            $table->foreignId('offerer_id')->constrained('users')->cascadeOnDelete();  // who makes the offer
            $table->unsignedBigInteger('cash_amount')->default(0); // optional money offer
            $table->json('offered_item_ids')->nullable(); // item-for-item trades
            $table->enum('status', ['pending', 'accepted', 'rejected', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
