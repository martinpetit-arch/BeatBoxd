<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artiste;
use App\Models\Morceau;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show($id)
    {
        $album = Album::findOrFail($id);

        return view('albums.show', [
            'album' => $album,
        ]);
    }

    public function create()
    {
        $artistes = Artiste::all();

        return view('albums.create', [
            'artistes' => $artistes,
        ]);
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'pochette' => 'nullable|string',
            'annee' => 'nullable|integer',
            'description' => 'nullable|string',
            'artiste_id' => 'required|exists:artistes,id',
            'chansons' => 'nullable|array',
            'chansons.*' => 'nullable|string|max:255',
        ]);

        // Vérifie si cet album existe déjà pour cet artiste
        $existe = Album::where('titre', $validated['titre'])
            ->where('artiste_id', $validated['artiste_id'])
            ->exists();

        if ($existe) {
            return back()->withErrors(['titre' => 'Cet album existe déjà pour cet artiste.'])->withInput();
        }

        $album = Album::create([
            'titre' => $validated['titre'],
            'pochette' => $validated['pochette'] ?? null,
            'annee' => $validated['annee'] ?? null,
            'description' => $validated['description'] ?? null,
            'artiste_id' => $validated['artiste_id'],
        ]);

        // Créer un morceau pour chaque titre rempli
        if (!empty($validated['chansons'])) {
            foreach ($validated['chansons'] as $index => $titreChanson) {
                if (!empty($titreChanson)) {
                    Morceau::create([
                        'titre' => $titreChanson,
                        'numero' => $index + 1,
                        'album_id' => $album->id,
                    ]);
                }
            }
        }

        return redirect('/albums/' . $album->id);
    }
}