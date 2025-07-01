<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OneSignalController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required|string'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->update([
            'onesignal_id' => $request->player_id
        ]);

        return response()->json(['message' => 'OneSignal ID saved']);
    }
}
