<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listes - BeatBoxd</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="{{ route('home') }}" aria-label="BeatBoxd">
                <img class="logo-image" src="{{ asset('assets/logo.svg') }}" alt="BeatBoxd">
            </a>
            <nav class="main-nav" aria-label="Navigation principale">
                <a href="{{ route('albums.index') }}">Albums</a>
                <a href="{{ route('artistes.index') }}">Artistes</a>
                <a href="{{ route('listes.index') }}">Listes</a>
            </nav>
            <div class="header-actions">
                @auth
                    <a class="header-button header-button-outline" href="{{ route('profil') }}">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="header-button header-button-outline" type="submit">Déconnexion</button>
                    </form>
                @else
                    <a class="header-button header-button-outline" href="{{ route('login') }}">Connexion</a>
                    <a class="header-button header-button-signup" href="{{ route('register') }}">S'inscrire</a>
                @endauth
                <a class="header-search" href="{{ route('recherche') }}" aria-label="Rechercher">⌕</a>
            </div>
        </div>
    </header>

    <main class="lists-page">
        <section class="lists-hero">
            <div class="container">
                <h1>Listes en fonction du mood</h1>
                <div class="list-filters">
                    <span>Filtrer par</span>
                    <select aria-label="Filtrer par année"><option>Année</option></select>
                    <select aria-label="Filtrer par évaluation"><option>Évaluation</option></select>
                    <select aria-label="Filtrer par genre"><option>Genre</option></select>
                    <form class="lists-search" method="GET" action="{{ route('recherche') }}">
                        <span aria-hidden="true">⌕</span>
                        <input type="search" name="q" placeholder="Rechercher une liste" aria-label="Rechercher une liste">
                    </form>
                </div>
                @auth
                    <a class="btn btn-primary lists-create-button" href="{{ route('listes.create') }}">Créer une liste</a>
                @endauth
            </div>
        </section>

        <div class="container lists-content">
            @forelse ($listes as $liste)
                <section class="list-shelf">
                    <div class="list-shelf-heading">
                        <div>
                            <h2><a href="{{ route('listes.show', $liste) }}">{{ $liste->nom }}</a></h2>
                            <p>Par {{ $liste->user->name }} · {{ $liste->albums_count }} album(s)</p>
                        </div>
                        @if ($liste->description)
                            <p>{{ $liste->description }}</p>
                        @endif
                    </div>

                    @if ($liste->albums->isNotEmpty())
                        <div class="album-grid">
                            @foreach ($liste->albums as $album)
                                @include('albums.partials.card', ['album' => $album])
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Cette liste ne contient encore aucun album.</p>
                    @endif
                </section>
            @empty
                <section class="list-shelf list-empty">
                    <h2>Aucune liste personnalisée</h2>
                    <p>Crée ta première liste pour regrouper les albums qui correspondent à ton humeur.</p>
                    @auth
                        <a class="btn btn-primary" href="{{ route('listes.create') }}">Créer une liste</a>
                    @endauth
                </section>
            @endforelse
        </div>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <a class="logo" href="{{ route('home') }}" aria-label="BeatBoxd">
                <img class="logo-image" src="{{ asset('assets/logo.svg') }}" alt="BeatBoxd">
            </a>
            <nav class="footer-links" aria-label="Pied de page">
                <a href="#">Conditions générales d'utilisation</a>
                <a href="#">Protection des données</a>
                <a href="#">Cookies</a>
                <a href="#">Confidentialité</a>
            </nav>
        </div>
    </footer>
</body>
</html>
