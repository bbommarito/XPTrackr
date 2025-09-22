<?php

use App\Models\MagicLink;
use App\Models\User;
use Illuminate\Database\QueryException;

describe('MagicLink Model - Happy Paths', function () {

    test('can create magic link with all required fields', function () {
        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'token' => 'unique-token-123',
            'expires_at' => now()->addMinutes(15),
            'used' => false,
        ]);

        expect($magicLink->user_id)->toBe($user->id)
            ->and($magicLink->token)->toBe('unique-token-123')
            ->and($magicLink->used)->toBeFalse()
            ->and($magicLink->expires_at)->not->toBeNull();
    });

    test('magic link belongs to user', function () {
        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'token' => 'token-123',
            'expires_at' => now()->addMinutes(15),
            'used' => false,
        ]);

        expect($magicLink->user)->toBeInstanceOf(User::class);
        expect($magicLink->user->id)->toBe($user->id);
    });

    test('can check if magic link is valid', function () {
        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'token' => 'valid-token',
            'expires_at' => now()->addMinutes(15),
            'used' => false,
        ]);

        expect($magicLink->isValid())->toBeTrue();
    });

    test('generates unique token automatically', function () {
        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            // Not providing token - should auto-generate
        ]);

        expect($magicLink->token)->not->toBeEmpty()
            ->and(strlen($magicLink->token))->toBe(36)
            ->and($magicLink->token)->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i');
        // UUID length
    });

    test('sets expires_at to 15 minutes from now automatically', function () {
        // Freeze time to a specific date/time to avoid timezone and day-change issues
        $this->travelTo('2025-01-15 10:00:00');

        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            // Not providing expires_at - should auto-set
        ]);

        expect($magicLink->expires_at)
            ->toBeInstanceOf(\Carbon\Carbon::class)
            ->and($magicLink->expires_at->format('Y-m-d H:i:s'))->toBe('2025-01-15 10:15:00');

        // Time is automatically reset after the test
    });
});

describe('MagicLink Model - Sad Paths', function () {

    test('magic link is invalid when expired', function () {
        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'token' => 'expired-token',
            'expires_at' => now()->subMinutes(5),
            'used' => false,
        ]);

        expect($magicLink->isValid())->toBeFalse();
    });

    test('magic link is invalid when already used', function () {
        $user = User::factory()->create();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'token' => 'used-token',
            'expires_at' => now()->addMinutes(15),
            'used' => true,
        ]);

        expect($magicLink->isValid())->toBeFalse();
    });

    test('cannot create magic link without required fields', function () {
        expect(fn () => MagicLink::create([]))
            ->toThrow(QueryException::class);
    });
});
