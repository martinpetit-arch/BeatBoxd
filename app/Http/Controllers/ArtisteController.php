<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use Illuminate\Http\Request;

class ArtisteController extends Controller
{
    public function index()
    {
        $artistes = Artiste::latest()->get();
        $artistesPopulaires = Artiste::withCount('fans')
            ->orderByDesc('fans_count')
            ->take(6)
            ->get();

        return view('artistes.index', [
            'artistesPopulaires' => $artistesPopulaires,
            'artistesDecouvrir' => $artistes->take(6),
            'artistesRecents' => $artistes->take(6),
        ]);
    }

    // Affiche le formulaire
    public function create()
    {
        return view('artistes.create');
    }

    public function edit(Artiste $artiste)
    {
        return view('artistes.edit', compact('artiste'));
    }

    // Traite le formulaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'photo' => 'nullable|string',
        ]);

        Artiste::create($validated);

        return redirect('/')->with('success', 'Artiste ajouté !');
    }

    public function update(Request $request, Artiste $artiste)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'photo' => 'nullable|string',
        ]);

        $artiste->update($validated);

        return redirect()->route('artistes.index');
    }
}
