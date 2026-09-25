<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Liste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ListeController extends Controller
{
    public function index(): View
    {
        return view('listes.index', [
            'listes' => Liste::with(['user', 'albums.artiste'])
                ->withCount('albums')
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('listes.create', [
            'albums' => Album::with('artiste')->orderBy('titre')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'albums' => 'nullable|array',
            'albums.*' => 'integer|exists:albums,id',
        ]);

        $liste = Liste::create([
            'user_id' => Auth::id(),
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
        ]);

        $liste->albums()->sync($validated['albums'] ?? []);

        return redirect()->route('listes.show', $liste);
    }

    public function show(Liste $liste): View
    {
        $liste->load(['user', 'albums.artiste']);

        return view('listes.show', [
            'liste' => $liste,
            'albumsDisponibles' => Album::whereNotIn('id', $liste->albums->modelKeys())
                ->with('artiste')
                ->orderBy('titre')
                ->get(),
        ]);
    }

    public function addAlbum(Request $request, Liste $liste): RedirectResponse
    {
        abort_unless($liste->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'album_id' => 'required|integer|exists:albums,id',
        ]);

        $liste->albums()->syncWithoutDetaching([$validated['album_id']]);

        return back();
    }

    public function removeAlbum(Liste $liste, Album $album): RedirectResponse
    {
        abort_unless($liste->user_id === Auth::id(), 403);

        $liste->albums()->detach($album);

        return back();
    }
}
