<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Liste;

class HomeController extends Controller
{
    public function index()
    {
        // Top 3 des albums les mieux notés (uniquement ceux qui ont au moins 1 critique)
        $topAlbums = Album::whereHas('critiques')
            ->withAvg('critiques', 'note')
            ->orderByDesc('critiques_avg_note')
            ->take(3)
            ->get();

        $derniersSingles = Album::whereHas('morceaux', null, '=', 1)
            ->with(['artiste', 'morceaux'])
            ->latest()
            ->take(5)
            ->get();

        // Les 6 derniers albums ajoutés (nouveautés)
        $nouveautes = Album::latest()->take(6)->get();
        $listes = Liste::with(['user', 'albums.artiste'])
            ->withCount('albums')
            ->latest()
            ->take(6)
            ->get();

        return view('home', [
            'topAlbums' => $topAlbums,
            'derniersSingles' => $derniersSingles,
            'nouveautes' => $nouveautes,
            'listes' => $listes,
        ]);
    }
}
