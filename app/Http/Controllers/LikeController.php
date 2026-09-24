<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
        ]);

        $like = Like::where('user_id', Auth::id())
            ->where('album_id', $validated['album_id'])
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'album_id' => $validated['album_id'],
            ]);
            $liked = true;
        }

        $total = Like::where('album_id', $validated['album_id'])->count();

        return response()->json([
            'liked' => $liked,
            'total' => $total,
        ]);
    }
}