<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BeatBoxd</title>
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

    <main class="home-page">
        <section class="hero">
            <div class="container">
                <p class="hero-subtitle">Bienvenue sur la plateforme BeatBoxd, la première plateforme dédiés aux mélomanes</p>
                <h1 class="hero-title">Qu'est-ce que la vie sans</h1>
                <h1 class="hero-title2">musique ?</h1>
                <form class="search" method="GET" action="{{ route('recherche') }}">
                    <span class="search-icon" aria-hidden="true">⌕</span>
                    <input type="search" name="q" placeholder="Rechercher un album, artiste ou morceau" aria-label="Rechercher">
                </form>
            </div>
        </section>
        
        <div class="container">
            <section class="section top-albums-section" id="top-albums">
                <div class="section-header"><h2 class="section-title">Nos top 3 des meilleurs albums {{ now()->year }}</h2></div>
                <img class="top-albums-vinyl" src="{{ asset('assets/vinyle.svg') }}" alt="">
                @if ($topAlbums->count() > 0)
                    <div class="top-albums">
                        @foreach ($topAlbums as $position => $album)
                            <article class="top-album">
                                @if ($album->pochette)
                                    <img class="top-album-cover" src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
                                @else
                                    <div class="top-album-cover album-cover-placeholder">No cover</div>
                                @endif
                                <div>
                                    <h3 class="top-album-heading">{{ $position + 1 }} - {{ $album->artiste->nom }}</h3>
                                    <h4 class="top-album-title"><a href="{{ route('albums.show', $album->id) }}">{{ $album->titre }}</a></h4>
                                    @if ($album->description)
                                        <p class="top-album-description">{{ $album->description }}</p>
                                    @endif
                                    <div class="album-rating">★ {{ number_format($album->critiques_avg_note, 1) }} / 5</div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p>Aucun album noté pour le moment.</p>
                @endif
            </section>

            <section class="section" id="nouveautes">
                <div class="section-header"><h2 class="section-title">Nouveautés de cette semaine</h2></div>
                @if ($nouveautes->count() > 0)
                    <div class="album-grid">
                        @foreach ($nouveautes as $album)
                            <article class="album-card">
                                <a href="{{ route('albums.show', $album->id) }}">
                                    @if ($album->pochette)
                                        <img class="album-cover" src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
                                    @else
                                        <div class="album-cover album-cover-placeholder">No cover</div>
                                    @endif
                                    <div class="album-info">
                                        <div class="album-title">{{ $album->titre }}</div>
                                        <div class="album-artist">{{ $album->artiste->nom }}</div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p>Aucun album pour le moment.</p>
                @endif
            </section>

            <section class="section" id="singles">
                <div class="section-header"><h2 class="section-title">Les derniers singles</h2></div>
                @if ($derniersSingles->isNotEmpty())
                    <div class="single-grid">
                        @foreach ($derniersSingles as $single)
                            @php($morceau = $single->morceaux->first())
                            <a class="single-card" href="{{ route('albums.show', $single->id) }}">
                                <img class="single-card-device" src="{{ asset('assets/naviguation-ipod.svg') }}" alt="">
                                <div class="single-card-screen">
                                    @if ($single->pochette)
                                        <img class="single-card-cover" src="{{ $single->pochette }}" alt="Pochette de {{ $single->titre }}">
                                    @else
                                        <div class="single-card-cover album-cover-placeholder">No cover</div>
                                    @endif
                                    <div class="single-card-track">
                                        <strong>{{ $morceau->titre }}</strong>
                                        <span>{{ $single->artiste->nom }}</span>
                                    </div>
                                    <div class="single-card-progress" aria-hidden="true"><span></span></div>
                                    <div class="single-card-duration">0:00 <span>{{ $morceau->duree_formatee ?? '--:--' }}</span></div>
                                </div>
                            </a>
                            <a class="single-card" href="{{ route('albums.show', $single->id) }}">
                                <img class="single-card-device" src="{{ asset('assets/naviguation-ipod.svg') }}" alt="">
                                <div class="single-card-screen">
                                    @if ($single->pochette)
                                        <img class="single-card-cover" src="{{ $single->pochette }}" alt="Pochette de {{ $single->titre }}">
                                    @else
                                        <div class="single-card-cover album-cover-placeholder">No cover</div>
                                    @endif
                                    <div class="single-card-track">
                                        <strong>{{ $morceau->titre }}</strong>
                                        <span>{{ $single->artiste->nom }}</span>
                                    </div>
                                    <div class="single-card-progress" aria-hidden="true"><span></span></div>
                                    <div class="single-card-duration">0:00 <span>{{ $morceau->duree_formatee ?? '--:--' }}</span></div>
                                </div>
                            </a>
                            <a class="single-card" href="{{ route('albums.show', $single->id) }}">
                                <img class="single-card-device" src="{{ asset('assets/naviguation-ipod.svg') }}" alt="">
                                <div class="single-card-screen">
                                    @if ($single->pochette)
                                        <img class="single-card-cover" src="{{ $single->pochette }}" alt="Pochette de {{ $single->titre }}">
                                    @else
                                        <div class="single-card-cover album-cover-placeholder">No cover</div>
                                    @endif
                                    <div class="single-card-track">
                                        <strong>{{ $morceau->titre }}</strong>
                                        <span>{{ $single->artiste->nom }}</span>
                                    </div>
                                    <div class="single-card-progress" aria-hidden="true"><span></span></div>
                                    <div class="single-card-duration">0:00 <span>{{ $morceau->duree_formatee ?? '--:--' }}</span></div>
                                </div>
                                <a class="single-card" href="{{ route('albums.show', $single->id) }}">
                                <img class="single-card-device" src="{{ asset('assets/naviguation-ipod.svg') }}" alt="">
                                <div class="single-card-screen">
                                    @if ($single->pochette)
                                        <img class="single-card-cover" src="{{ $single->pochette }}" alt="Pochette de {{ $single->titre }}">
                                    @else
                                        <div class="single-card-cover album-cover-placeholder">No cover</div>
                                    @endif
                                    <div class="single-card-track">
                                        <strong>{{ $morceau->titre }}</strong>
                                        <span>{{ $single->artiste->nom }}</span>
                                    </div>
                                    <div class="single-card-progress" aria-hidden="true"><span></span></div>
                                    <div class="single-card-duration">0:00 <span>{{ $morceau->duree_formatee ?? '--:--' }}</span></div>
                                </div>
                            </a>
                            <a class="single-card" href="{{ route('albums.show', $single->id) }}">
                                <img class="single-card-device" src="{{ asset('assets/naviguation-ipod.svg') }}" alt="">
                                <div class="single-card-screen">
                                    @if ($single->pochette)
                                        <img class="single-card-cover" src="{{ $single->pochette }}" alt="Pochette de {{ $single->titre }}">
                                    @else
                                        <div class="single-card-cover album-cover-placeholder">No cover</div>
                                    @endif
                                    <div class="single-card-track">
                                        <strong>{{ $morceau->titre }}</strong>
                                        <span>{{ $single->artiste->nom }}</span>
                                    </div>
                                    <div class="single-card-progress" aria-hidden="true"><span></span></div>
                                    <div class="single-card-duration">0:00 <span>{{ $morceau->duree_formatee ?? '--:--' }}</span></div>
                                </div>
                            </a>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p>Aucun single pour le moment.</p>
                @endif
            </section>

            <section class="section" id="listes">
                <div class="section-header"><h2 class="section-title">En fonction du mood</h2></div>
                @if ($listes->count() > 0)
                    <div class="list-grid">
                        @foreach ($listes as $liste)
                            <article class="list-card">
                                <h3 class="list-card-title"><a href="{{ route('listes.show', $liste) }}">{{ $liste->nom }}</a></h3>
                                <p class="list-card-meta">Par {{ $liste->user->name }} · {{ $liste->albums_count }} album(s)</p>
                                @if ($liste->description)
                                    <p class="list-card-description">{{ $liste->description }}</p>
                                @endif
                                <div class="list-card-covers">
                                    @foreach ($liste->albums->take(3) as $album)
                                        <a href="{{ route('albums.show', $album->id) }}">
                                            @if ($album->pochette)
                                                <img class="list-card-cover" src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
                                            @else
                                                <span class="list-card-cover album-cover-placeholder">No cover</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p>Aucune liste personnalisée pour le moment.</p>
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
