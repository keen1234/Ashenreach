<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->string('action_type'); // e.g. 'gather', 'combat', 'craft'
            $table->integer('roll_die');
            $table->integer('stat_modifier');
            $table->integer('skill_bonus')->default(0);
            $table->integer('total_roll');
            $table->integer('difficulty_class');
            $table->boolean('success');
            $table->json('rewards')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
