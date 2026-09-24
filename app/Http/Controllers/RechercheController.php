<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artiste;
use App\Models\Morceau;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function index(Request $request)
    {
        $terme = trim((string) $request->input('q', ''));

        $albums = collect();
        $artistes = collect();
        $morceaux = collect();

        if ($terme !== '') {
            $albums = Album::where('titre', 'like', '%' . $terme . '%')->get();
            $artistes = Artiste::where('nom', 'like', '%' . $terme . '%')->get();
            $morceaux = Morceau::where('titre', 'like', '%' . $terme . '%')->with('album.artiste')->get();
        }

        return view('recherche', [
            'terme' => $terme,
            'albums' => $albums,
            'artistes' => $artistes,
            'morceaux' => $morceaux,
        ]);
    }
}