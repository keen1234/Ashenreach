<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('characters')->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('characters')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('total_price');
            $table->unsignedInteger('tax_paid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_logs');
    }
};
