<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\MagicLink;
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

        // Create magic link
        $magicLink = MagicLink::create([
            'user_id' => $user->id,
        ]);

        // TODO: Send notification with magic link

        return redirect()->route('home')->with('success', 'Magic link sent!');
    }
}
