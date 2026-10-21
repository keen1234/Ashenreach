<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->unique()->firstName() . ' the Brave',
            'race' => 'human',
            'level' => 1,
            'experience' => 0,
            'strength' => 10,
            'dexterity' => 10,
            'constitution' => 10,
            'intelligence' => 10,
            'wisdom' => 10,
            'charisma' => 10,
            'gold' => 100,
            'stamina' => 100,
            'stamina_updated_at' => now(),
            'courage' => 20,
            'courage_updated_at' => now(),
            'focus' => 50,
            'focus_updated_at' => now(),
        ];
    }
}
