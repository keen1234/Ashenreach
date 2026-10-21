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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('race');
            $table->unsignedInteger('level')->default(1);
            $table->unsignedBigInteger('experience')->default(0);

            // Base attributes (before racial bonuses)
            $table->unsignedInteger('strength')->default(8);
            $table->unsignedInteger('dexterity')->default(8);
            $table->unsignedInteger('constitution')->default(8);
            $table->unsignedInteger('intelligence')->default(8);
            $table->unsignedInteger('wisdom')->default(8);
            $table->unsignedInteger('charisma')->default(8);

            // Economy & Bars
            $table->unsignedBigInteger('gold')->default(100);
            $table->unsignedInteger('stamina')->default(100);
            $table->timestamp('stamina_updated_at')->useCurrent();
            $table->unsignedInteger('courage')->default(20);
            $table->timestamp('courage_updated_at')->useCurrent();
            $table->unsignedInteger('focus')->default(50);
            $table->timestamp('focus_updated_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
