<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artiste;
use App\Models\Morceau;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artiste')->latest()->get();
        $albumsPopulaires = Album::whereHas('critiques')
            ->with(['artiste'])
            ->withAvg('critiques', 'note')
            ->orderByDesc('critiques_avg_note')
            ->take(6)
            ->get();

        return view('albums.index', [
            'albums' => $albums,
            'albumsPopulaires' => $albumsPopulaires,
            'nouveautes' => $albums->take(6),
            'albumsHouse' => $albums->take(6),
        ]);
    }

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

    public function edit(Album $album)
    {
        return view('albums.edit', [
            'album' => $album->load('morceaux'),
            'artistes' => Artiste::all(),
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
        if (! empty($validated['chansons'])) {
            foreach ($validated['chansons'] as $index => $titreChanson) {
                if (! empty($titreChanson)) {
                    Morceau::create([
                        'titre' => $titreChanson,
                        'numero' => $index + 1,
                        'album_id' => $album->id,
                    ]);
                }
            }
        }

        return redirect('/albums/'.$album->id);
    }

    public function update(Request $request, Album $album)
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

        $existe = Album::where('id', '!=', $album->id)
            ->where('titre', $validated['titre'])
            ->where('artiste_id', $validated['artiste_id'])
            ->exists();

        if ($existe) {
            return back()->withErrors(['titre' => 'Cet album existe déjà pour cet artiste.'])->withInput();
        }

        $album->update([
            'titre' => $validated['titre'],
            'pochette' => $validated['pochette'] ?? null,
            'annee' => $validated['annee'] ?? null,
            'description' => $validated['description'] ?? null,
            'artiste_id' => $validated['artiste_id'],
        ]);

        if (array_key_exists('chansons', $validated)) {
            $album->morceaux()->delete();

            foreach ($validated['chansons'] ?? [] as $index => $titreChanson) {
                if (! empty($titreChanson)) {
                    Morceau::create([
                        'titre' => $titreChanson,
                        'numero' => $index + 1,
                        'album_id' => $album->id,
                    ]);
                }
            }
        }

        return redirect()->route('albums.show', $album);
    }
}
