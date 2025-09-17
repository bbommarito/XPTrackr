<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;

describe('Magic Link Authentication - Happy Paths', function () {
    test('magic link creates user if they dont exist', function () {
        Mail::fake();

        expect(User::where('email', 'new@example.com')->exists())->toBeFalse();

        $this->post(route('magic-link.request'), [
            'email' => 'new@example.com',
        ]);

        expect(User::where('email', 'new@example.com')->exists())->toBeTrue();
    });

});
