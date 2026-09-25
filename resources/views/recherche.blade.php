<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recherche - BeatBoxd</title>
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
            <a class="header-search" href="{{ route('recherche') }}" aria-label="Rechercher">⌕</a>
        </div>
    </header>

    <main class="search-page">
        <section class="search-hero">
            <div class="container">
                <p class="search-kicker">Recherche</p>
                <h1>Que veux-tu écouter ?</h1>
                <form class="search-page-form" method="GET" action="{{ route('recherche') }}">
                    <input type="search" name="q" value="{{ $terme }}" placeholder="Olivia, un album ou un morceau" aria-label="Rechercher">
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </form>
            </div>
        </section>

        <div class="container search-content">
            @if ($terme !== '')
                <p class="search-results-label">Résultats pour « {{ $terme }} »</p>

                <section class="search-results-section">
                    <div class="search-section-heading">
                        <h2>Albums</h2>
                        <span>{{ $albums->count() }}</span>
                    </div>
                    @if ($albums->isNotEmpty())
                        <div class="search-album-grid">
                            @foreach ($albums as $album)
                                <a class="search-album-card" href="{{ route('albums.show', $album) }}">
                                    @if ($album->pochette)
                                        <img src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
                                    @else
                                        <span class="album-cover-placeholder">No cover</span>
                                    @endif
                                    <strong>{{ $album->titre }}</strong>
                                    <span>{{ $album->artiste?->nom ?? 'Artiste inconnu' }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="search-empty">Aucun album trouvé.</p>
                    @endif
                </section>

                <section class="search-results-section search-list-section">
                    <div class="search-section-heading">
                        <h2>Artistes</h2>
                        <span>{{ $artistes->count() }}</span>
                    </div>
                    @forelse ($artistes as $artiste)
                        <a class="search-result-row" href="{{ route('recherche', ['q' => $artiste->nom]) }}">
                            <span class="search-result-avatar">{{ strtoupper(substr($artiste->nom, 0, 1)) }}</span>
                            <strong>{{ $artiste->nom }}</strong>
                        </a>
                    @empty
                        <p class="search-empty">Aucun artiste trouvé.</p>
                    @endforelse
                </section>

                <section class="search-results-section search-list-section">
                    <div class="search-section-heading">
                        <h2>Morceaux</h2>
                        <span>{{ $morceaux->count() }}</span>
                    </div>
                    @forelse ($morceaux as $morceau)
                        <a class="search-result-row" href="{{ route('albums.show', $morceau->album_id) }}">
                            <span class="search-result-icon">♪</span>
                            <span><strong>{{ $morceau->titre }}</strong><small>{{ $morceau->album?->artiste?->nom ?? 'Artiste inconnu' }}</small></span>
                        </a>
                    @empty
                        <p class="search-empty">Aucun morceau trouvé.</p>
                    @endforelse
                </section>
            @else
                <p class="search-empty search-empty-start">Commence une recherche pour retrouver un album, un artiste ou un morceau.</p>
            @endif
        </div>
    </main>
</body>
</html>