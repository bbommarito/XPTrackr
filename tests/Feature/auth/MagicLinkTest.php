<?php

use App\Models\MagicLink;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

describe('Magic Link Authentication - Happy Paths', function () {
    test('magic link creates user if they dont exist', function () {
        Notification::fake();

        expect(User::where('email', 'new@example.com')->exists())->toBeFalse();

        $this->post(route('magic-link.request'), [
            'email' => 'new@example.com',
        ]);

        expect(User::where('email', 'new@example.com')->exists())->toBeTrue();
    });

    test('magic link record is created with valid token', function () {
        Notification::fake();

        $this->post(route('magic-link.request'), [
            'email' => 'john@example.com',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $magicLink = MagicLink::where('user_id', $user->id)->first();

        expect($magicLink)->not->toBeNull()
            ->and($magicLink->token)->not->toBeEmpty()
            ->and($magicLink->expires_at)->toBeGreaterThan(now())
            ->and($magicLink->used)->toBeFalse();
    });

    test('user can request magic link with valid email', function () {
        Notification::fake();

        $response = $this->post(route('magic-link.request'), [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Magic link sent!');

        Notification::assertSentTo(
            User::where('email', 'john@example.com')->first(),
            \App\Notifications\MagicLinkNotification::class
        );
    });
});
