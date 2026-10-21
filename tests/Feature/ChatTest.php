<?php

use App\Models\Character;
use App\Models\Message;

test('character can send message to chat channel', function () {
    $character = Character::factory()->create();

    $message = Message::create([
        'character_id' => $character->id,
        'body' => 'Hail travelers, selling iron ore!',
        'channel' => 'trade',
    ]);

    expect($message->body)->toBe('Hail travelers, selling iron ore!');
    expect($message->channel)->toBe('trade');
    expect($message->character_id)->toBe($character->id);
});

test('message can be reported for moderation', function () {
    $character = Character::factory()->create();

    $message = Message::create([
        'character_id' => $character->id,
        'body' => 'Inappropriate text',
    ]);

    $message->update(['is_reported' => true]);

    expect($message->fresh()->is_reported)->toBeTrue();
});
