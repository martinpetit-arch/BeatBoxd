<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Albums - BeatBoxd</title>
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

    <main class="albums-page">
        <section class="albums-hero">
            <div class="container">
                <h1>Les albums</h1>
                <div class="album-filters">
                    <span>Filtrer par</span>
                    <select aria-label="Filtrer par année">
                        <option>Année</option>
                    </select>
                    <select aria-label="Filtrer par évaluation">
                        <option>Évaluation</option>
                    </select>
                    <select aria-label="Filtrer par genre">
                        <option>Genre</option>
                    </select>
                    <form class="albums-search" method="GET" action="{{ route('recherche') }}">
                        <span aria-hidden="true">⌕</span>
                        <input type="search" name="q" placeholder="Rechercher un album, artiste ou morceau" aria-label="Rechercher dans les albums">
                    </form>
                </div>
            </div>
        </section>

        <div class="container albums-content">
            <section class="album-shelf">
                <h2>Les plus écoutés du mois</h2>
                @if ($albumsPopulaires->isNotEmpty())
                    <div class="album-grid">
                        @foreach ($albumsPopulaires as $album)
                            @include('albums.partials.card', ['album' => $album])
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Aucun album évalué pour le moment.</p>
                @endif
            </section>

            <section class="album-shelf">
                <h2>Les nouveautés de la semaine</h2>
                @if ($nouveautes->isNotEmpty())
                    <div class="album-grid">
                        @foreach ($nouveautes as $album)
                            @include('albums.partials.card', ['album' => $album])
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Aucun album pour le moment.</p>
                @endif
            </section>

            <section class="album-shelf">
                <h2>House</h2>
                @if ($albumsHouse->isNotEmpty())
                    <div class="album-grid">
                        @foreach ($albumsHouse as $album)
                            @include('albums.partials.card', ['album' => $album])
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Aucun album dans cette catégorie.</p>
                @endif
            </section>
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
