<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Quest;

class OnboardingService
{
    /**
     * Initialize starter kit and first guided quest for a newly created character.
     */
    public function initializeOnboarding(Character $character): void
    {
        // Starter kit gold (100 gold)
        $character->gold = 100;
        $character->save();

        // First guided quest: "The First Gathering"
        Quest::create([
            'character_id' => $character->id,
            'name' => 'The First Gathering: Gather herbs in the Whispering Woods',
            'status' => 'active',
        ]);
    }
}
