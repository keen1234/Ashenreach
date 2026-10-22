<?php

use App\Models\Character;
use App\Services\ActionService;
use App\Services\BarService;
use App\Services\DiceService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Title('Home - Ashenreach')]
#[Layout('layouts::game')]
class extends Component {
    public ?Character $character = null;

    // Vitals
    public int $stamina = 100;
    public int $courage = 20;
    public int $focus = 50;

    // Actions
    public int $actionsLeft = 2;

    // Dice Roller State
    public ?int $rolledDie = null;
    public ?int $rollTotal = null;
    public string $rollMessage = 'Awaiting your hand';

    public function mount(BarService $barService): void
    {
        $user = Auth::user();
        $this->character = Character::where('user_id', $user->id)->first();

        if (! $this->character) {
            $this->character = Character::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'race' => 'human',
                'level' => 7,
                'strength' => 14,
                'dexterity' => 12,
                'constitution' => 14,
                'intelligence' => 12,
                'wisdom' => 12,
                'charisma' => 10,
                'gold' => 240,
                'stamina' => 98,
                'courage' => 72,
                'focus' => 41,
            ]);
        }

        $this->refreshVitals($barService);
    }

    public function refreshVitals(BarService $barService): void
    {
        if ($this->character) {
            $this->stamina = $barService->getCurrentValue($this->character, 'stamina');
            $this->courage = $barService->getCurrentValue($this->character, 'courage');
            $this->focus = $barService->getCurrentValue($this->character, 'focus');
        }
    }

    public function rollDie(DiceService $diceService): void
    {
        $statMod = $this->character ? $this->character->getModifier('dexterity') : 0;
        $prof = 1;
        $dc = 14;

        $result = $diceService->check($dc, $statMod, $prof);

        $this->rolledDie = $result['die'];
        $this->rollTotal = $result['total'];

        if ($result['crit_success']) {
            $this->rollMessage = 'Critical Success! The ferryman bows.';
        } elseif ($result['crit_fail']) {
            $this->rollMessage = 'Critical Failure! You slip into the black water.';
        } elseif ($result['success']) {
            $this->rollMessage = 'Success! You reach the far bank dry.';
        } else {
            $this->rollMessage = 'Failure! The current pulls at your boots.';
        }
    }

    public function takeAction(ActionService $actionService, BarService $barService): void
    {
        if ($this->actionsLeft <= 0) {
            return;
        }

        try {
            $actionService->gather($this->character);
            $this->actionsLeft -= 1;
            $this->refreshVitals($barService);
            $this->character->refresh();
        } catch (\Exception $e) {
            // handle error
        }
    }
}; ?>

<div class="max-w-6xl mx-auto w-full p-6 lg:p-10 flex flex-col gap-8">
    <!-- Header -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-iron" style="border-bottom: 1px solid #262626;">
        <div class="flex flex-col gap-1">
            <span class="text-xs uppercase tracking-widest text-gold font-semibold">The realm · nightfall</span>
            <h1 class="text-3xl font-serif font-extrabold text-bone">The realm remembers your deeds.</h1>
            <p class="text-sm text-silver">Ashfall settles over the Ashen Marches. The gate is shut, the watchfires are low.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-3 py-1 rounded-full bg-coal border border-iron text-xs text-silver">Day 42</span>
            <span class="px-3 py-1 rounded-full bg-coal border border-iron text-xs text-silver">02:14</span>
            <span class="px-3 py-1 rounded-full bg-coal border border-gold text-xs text-gold">Ashfall · light</span>
        </div>
    </header>

    <div class="text-xs text-silver flex items-center gap-3">
        <span>{{ $character?->name ?? 'Warden' }}</span><span>·</span>
        <span>Level {{ $character?->level ?? 7 }}</span><span>·</span>
        <span>{{ $actionsLeft }} actions remain</span><span>·</span>
        <span>Gold: {{ $character?->gold ?? 0 }}g</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="flex flex-col gap-6">
            <!-- Zone Banner -->
            <div class="bg-coal border border-iron rounded-2xl p-6 flex items-center gap-5 relative overflow-hidden" style="background-color: #171717; border: 1px solid #262626;">
                <div class="flex-1 flex flex-col gap-2">
                    <span class="text-xs uppercase tracking-wider text-silver">Zone · contested</span>
                    <h2 class="text-xl font-serif font-bold text-bone">The Ashen Marches</h2>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded bg-obsidian border border-iron text-xs text-silver">Danger II</span>
                        <span class="px-2.5 py-0.5 rounded bg-obsidian border border-iron text-xs text-silver">Night</span>
                    </div>
                </div>
            </div>

            <!-- Dice Roller Panel -->
            <div class="bg-coal border border-iron rounded-2xl p-6 flex flex-col gap-4" style="background-color: #171717; border: 1px solid #262626;" wire:ignore.self>
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-gold font-semibold">The crossing</span>
                        <h3 class="text-lg font-serif font-bold text-bone">Grace check · DC 14</h3>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded bg-obsidian border border-iron text-silver">public roll</span>
                </div>
                <p class="text-sm text-silver">The rope is old, the water is black, and the ferryman is watching. One roll decides whether you reach the far bank dry.</p>

                <div class="bg-obsidian border border-iron rounded-xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4" style="background-color: #0E0E0E; border: 1px solid #262626;">
                    <div class="text-center sm:text-left">
                        <span class="text-xs uppercase tracking-wider text-silver">Result</span>
                        <div class="text-2xl font-mono font-bold text-gold mt-1">
                            @if($rolledDie)
                                {{ $rolledDie }} + {{ $character?->getModifier('dexterity') ?? 1 }} + 1 = {{ $rollTotal }}
                            @else
                                —
                            @endif
                        </div>
                        <div class="text-xs text-silver mt-1">{{ $rollMessage }}</div>
                    </div>
                    <button wire:click="rollDie" type="button" class="px-5 py-3 rounded-xl font-bold uppercase tracking-wider text-obsidian bg-gradient-to-r from-gold to-gold-light hover:opacity-90 transition shadow-lg text-sm" style="background: linear-gradient(to right, #C9A24D, #DFBE72); color: #0E0E0E;">
                        Roll the die
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column (Vitals & Actions) -->
        <div class="flex flex-col gap-6">
            <!-- Vitals Panel -->
            <div class="bg-coal border border-iron rounded-2xl p-6 flex flex-col gap-5" style="background-color: #171717; border: 1px solid #262626;">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-serif font-bold text-bone">Vitals</h3>
                    <span class="text-xs text-silver">regenerating</span>
                </div>

                <!-- Stamina -->
                <div class="flex flex-col gap-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-silver">Stamina</span>
                        <span class="text-bone"><b>{{ $stamina }}</b> / 100</span>
                    </div>
                    <div class="w-full bg-obsidian h-2.5 rounded-full overflow-hidden border border-iron" style="background-color: #0E0E0E;">
                        <div class="bg-gold h-full rounded-full transition-all duration-300" style="width: {{ $stamina }}%; background-color: #C9A24D;"></div>
                    </div>
                </div>

                <!-- Courage -->
                <div class="flex flex-col gap-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-silver">Courage</span>
                        <span class="text-bone"><b>{{ $courage }}</b> / 100</span>
                    </div>
                    <div class="w-full bg-obsidian h-2.5 rounded-full overflow-hidden border border-iron" style="background-color: #0E0E0E;">
                        <div class="h-full rounded-full transition-all duration-300" style="width: {{ $courage }}%; background-color: #5FA05A;"></div>
                    </div>
                </div>

                <!-- Focus -->
                <div class="flex flex-col gap-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-silver">Focus</span>
                        <span class="text-bone"><b>{{ $focus }}</b> / 100</span>
                    </div>
                    <div class="w-full bg-obsidian h-2.5 rounded-full overflow-hidden border border-iron" style="background-color: #0E0E0E;">
                        <div class="h-full rounded-full transition-all duration-300" style="width: {{ $focus }}%; background-color: #5383C3;"></div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-coal border border-iron rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-xl" style="background-color: #171717; border: 1px solid #262626;">
                <div>
                    <div class="text-xs uppercase tracking-wider text-gold font-semibold">{{ $actionsLeft }} actions remain</div>
                    <div class="text-xs text-silver mt-0.5">Resets at nightfall</div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-iron text-silver hover:text-bone hover:border-gold transition text-sm">
                            Log out
                        </button>
                    </form>
                    <button wire:click="takeAction" type="button" @if($actionsLeft <= 0) disabled @endif class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-bold uppercase tracking-wider text-obsidian bg-gradient-to-r from-gold to-gold-light hover:opacity-90 transition text-sm disabled:opacity-50 disabled:cursor-not-allowed" style="background: linear-gradient(to right, #C9A24D, #DFBE72); color: #0E0E0E;">
                        Take an action
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
