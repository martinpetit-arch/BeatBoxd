<?php

namespace App\Http\Controllers;

use App\Models\Album;

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

        // Les 6 derniers albums ajoutés (nouveautés)
        $nouveautes = Album::latest()->take(6)->get();

        return view('home', [
            'topAlbums' => $topAlbums,
            'nouveautes' => $nouveautes,
        ]);
    }
}