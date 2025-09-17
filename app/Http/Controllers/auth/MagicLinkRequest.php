<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MagicLinkRequest extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::firstOrCreate([
            'email' => $request->email,
        ]);

        $user->save();

        return redirect()->route('home')->with('success', 'Magic link sent! Check your email.');
    }
}
