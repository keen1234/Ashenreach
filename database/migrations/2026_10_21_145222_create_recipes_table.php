<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('result_item_id')->constrained('items')->cascadeOnDelete();
            $table->unsignedInteger('focus_cost')->default(5);
            $table->unsignedInteger('difficulty_class')->default(12);
            $table->string('skill_required')->default('blacksmithing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
