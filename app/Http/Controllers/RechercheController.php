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
            $mots = preg_split('/\s+/', $terme);
            $mots = array_values(array_filter($mots, fn ($mot) => $mot !== ''));

            $albums = Album::where(function ($query) use ($mots) {
                foreach ($mots as $mot) {
                    $query->orWhere('titre', 'like', '%'.$mot.'%');
                }
            })->get();

            $artistes = Artiste::where(function ($query) use ($mots) {
                foreach ($mots as $mot) {
                    $query->orWhere('nom', 'like', '%'.$mot.'%');
                }
            })->get();

            $morceaux = Morceau::where(function ($query) use ($mots) {
                foreach ($mots as $mot) {
                    $query->orWhere('titre', 'like', '%'.$mot.'%');
                }
            })->with('album.artiste')->get();
        }

        return view('recherche', [
            'terme' => $terme,
            'albums' => $albums,
            'artistes' => $artistes,
            'morceaux' => $morceaux,
        ]);
    }
}
