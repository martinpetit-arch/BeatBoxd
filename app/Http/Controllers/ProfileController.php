<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artiste;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        return view('profil', [
            'user' => $user,
            'albumsFavoris' => $user->likes()->with('album.artiste')->latest()->get()->pluck('album'),
            'artistesFavoris' => $user->fans()->with('artiste')->latest()->get()->pluck('artiste'),
            'notes' => $user->critiques()->with('album.artiste')->latest()->get(),
            'albumsDisponibles' => Album::with('artiste')->orderBy('titre')->get(),
            'artistesDisponibles' => Artiste::orderBy('nom')->get(),
        ]);
    }
}
