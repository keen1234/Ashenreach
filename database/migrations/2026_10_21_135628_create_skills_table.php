<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // mining, blacksmithing, alchemy, herbalism, farming, fishing, stealth, trading, combat
            $table->unsignedInteger('level')->default(1);
            $table->unsignedBigInteger('experience')->default(0);
            $table->timestamps();

            $table->unique(['character_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
