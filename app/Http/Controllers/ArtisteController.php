<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use Illuminate\Http\Request;

class ArtisteController extends Controller
{
    // Affiche le formulaire
    public function create()
    {
        return view('artistes.create');
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
}