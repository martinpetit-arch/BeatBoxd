<?php

namespace App\Http\Controllers;

use App\Models\Critique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CritiqueController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'note' => 'required|numeric|min:0.5|max:5',
            'avis' => 'nullable|string',
            'album_id' => 'required|exists:albums,id',
        ]);

        Critique::create([
            'note' => $validated['note'],
            'avis' => $validated['avis'] ?? null,
            'user_id' => Auth::id(),
            'album_id' => $validated['album_id'],
        ]);

        return redirect('/albums/' . $validated['album_id']);
    }
}