<?php

use App\Models\MagicLink;
use App\Models\User;
use App\Notifications\MagicLinkNotification;
use Illuminate\Notifications\Messages\MailMessage;

describe('MagicLinkNotification', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->magicLink = MagicLink::create([
            'user_id' => $this->user->id,
        ]);
        $this->notification = new MagicLinkNotification($this->magicLink);
    });

    test('notification is sent via mail channel', function () {
        $channels = $this->notification->via($this->user);

        expect($channels)->toBe(['mail']);
    });

    test('mail message contains correct content', function () {
        $mailMessage = $this->notification->toMail($this->user);

        expect($mailMessage)
            ->toBeInstanceOf(MailMessage::class)
            ->and($mailMessage->subject)->toBe('Your Magic Link for '.config('app.name'))
            ->and($mailMessage->greeting)->toBe('Hello!')
            ->and($mailMessage->introLines)->toContain('Click the button below to sign in to your account.')
            ->and($mailMessage->outroLines)->toContain('This link will expire in 15 minutes.')
            ->and($mailMessage->outroLines)->toContain('If you did not request this link, please ignore this email.');
    });

    test('mail message contains correct action button', function () {
        $mailMessage = $this->notification->toMail($this->user);
        // TODO: Use route() once magic-link.verify route is created
        $expectedUrl = url("/magic-link/{$this->magicLink->token}");

        expect($mailMessage->actionText)->toBe('Sign In')
            ->and($mailMessage->actionUrl)->toBe($expectedUrl);
    });

    test('notification can be serialized to array', function () {
        $array = $this->notification->toArray($this->user);

        expect($array)
            ->toHaveKey('magic_link_id', $this->magicLink->id)
            ->toHaveKey('expires_at')
            ->and($array['expires_at']->toDateTimeString())
            ->toBe($this->magicLink->expires_at->toDateTimeString());
    });

    test('notification includes magic link token in URL', function () {
        $mailMessage = $this->notification->toMail($this->user);

        expect($mailMessage->actionUrl)->toContain($this->magicLink->token);
    });

    test('notification URL uses correct route pattern', function () {
        $mailMessage = $this->notification->toMail($this->user);
        $expectedPattern = '/magic-link/';

        expect($mailMessage->actionUrl)
            ->toContain($expectedPattern)
            ->toMatch('/^https?:\/\/.*\/magic-link\/[a-f0-9\-]{36}$/');
    });
});

describe('MagicLinkNotification - Edge Cases', function () {
    test('notification handles expired magic link gracefully', function () {
        $user = User::factory()->create();
        $expiredMagicLink = MagicLink::create([
            'user_id' => $user->id,
            'expires_at' => now()->subMinutes(30), // Already expired
        ]);

        $notification = new MagicLinkNotification($expiredMagicLink);
        $mailMessage = $notification->toMail($user);

        // Should still generate the email even if link is expired
        expect($mailMessage)->toBeInstanceOf(MailMessage::class)
            ->and($mailMessage->actionUrl)->toContain($expiredMagicLink->token);
    });

    test('notification handles used magic link', function () {
        $user = User::factory()->create();
        $usedMagicLink = MagicLink::create([
            'user_id' => $user->id,
            'used' => true,
        ]);

        $notification = new MagicLinkNotification($usedMagicLink);
        $mailMessage = $notification->toMail($user);

        // Should still generate the email even if link is used
        expect($mailMessage)->toBeInstanceOf(MailMessage::class)
            ->and($mailMessage->actionUrl)->toContain($usedMagicLink->token);
    });
});
