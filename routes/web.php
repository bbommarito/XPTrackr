<?php

use App\Http\Controllers\auth\MagicLinkRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/magic-link/request', MagicLinkRequest::class)->name('magic-link.request');
