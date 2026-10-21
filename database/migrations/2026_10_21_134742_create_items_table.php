<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // weapon, armor, material, potion
            $table->string('rarity')->default('common'); // common, uncommon, rare, epic, legendary
            $table->unsignedInteger('base_value')->default(1);
            $table->unsignedInteger('max_durability')->default(50);
            $table->unsignedInteger('weight')->default(1);
            $table->boolean('is_bound')->default(false);
            $table->json('stats')->nullable(); // bonus stats e.g. {"strength": 2}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
