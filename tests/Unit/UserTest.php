<?php

use App\Models\User;

test('username is set from email prefix when user is created', function () {
    // Create a user with only an email
    $user = User::create([
        'email' => 'john.doe@example.com',
    ]);

    // Assert that the username was set to the part before @
    expect($user->username)->toBe('john.doe');
});

test('username is set correctly for various email formats', function ($email, $expectedUsername) {
    // Create a user with the given email
    $user = User::create([
        'email' => $email,
    ]);

    // Assert that the username matches the expected value
    expect($user->username)->toBe($expectedUsername);
})->with([
    ['simple@example.com', 'simple'],
    ['first.last@company.com', 'first.last'],
    ['user+tag@domain.org', 'user+tag'],
    ['test_user@test.net', 'test_user'],
    ['admin123@site.io', 'admin123'],
]);

test('explicitly provided username takes precedence over email-derived username', function () {
    // Create a user with both email and username
    $user = User::create([
        'email' => 'john.doe@example.com',
        'username' => 'custom_username',
    ]);

    // Assert that the explicitly provided username is used
    expect($user->username)->toBe('custom_username');
});
