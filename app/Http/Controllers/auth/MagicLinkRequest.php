<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\MagicLink;
use App\Models\User;
use App\Notifications\MagicLinkNotification;
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

        // Send notification with magic link
        $user->notify(new MagicLinkNotification($magicLink));

        return redirect()->route('home')->with('success', 'Magic link sent!');
    }
}
