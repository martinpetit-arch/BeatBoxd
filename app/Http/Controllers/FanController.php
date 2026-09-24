<?php

namespace App\Http\Controllers;

use App\Models\Fan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FanController extends Controller
{
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'artiste_id' => 'required|exists:artistes,id',
        ]);

        $fan = Fan::where('user_id', Auth::id())
            ->where('artiste_id', $validated['artiste_id'])
            ->first();

        if ($fan) {
            $fan->delete();
            $estFan = false;
        } else {
            Fan::create([
                'user_id' => Auth::id(),
                'artiste_id' => $validated['artiste_id'],
            ]);
            $estFan = true;
        }

        $total = Fan::where('artiste_id', $validated['artiste_id'])->count();

        return response()->json([
            'estFan' => $estFan,
            'total' => $total,
        ]);
    }
}