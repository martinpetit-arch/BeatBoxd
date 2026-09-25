<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $album->titre }} - BeatBoxd</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <main class="album-page">
        <div class="container">
            <section class="album-detail">
                <div class="album-detail-main">
                    <div class="album-detail-media">
                        @if ($album->pochette)
                            <img class="album-detail-cover" src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
                        @else
                            <div class="album-detail-cover album-cover-placeholder">No cover</div>
                        @endif
                        @php($noteMoyenne = round((float) $album->note_moyenne * 2) / 2)
                        <div class="album-detail-rating" aria-label="Note moyenne : {{ number_format($noteMoyenne, 1) }} sur 5">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $noteMoyenne)
                                    <img src="{{ asset('assets/star-full.svg') }}" alt="Étoile pleine">
                                @elseif ($i - 0.5 == $noteMoyenne)
                                    <img src="{{ asset('assets/star-half.svg') }}" alt="Demi-étoile">
                                @else
                                    <img class="rating-star-empty" src="{{ asset('assets/star-full.svg') }}" alt="Étoile vide">
                                @endif
                            @endfor
                            <span class="rating-value">{{ number_format($noteMoyenne, 1) }}/5</span>
                        </div>
                        @auth
                            <button class="like-button" id="bouton-like" type="button" data-album-id="{{ $album->id }}">
                                {{ $album->estLikePar(auth()->id()) ? '♥' : '♡' }} <span id="compteur-like">{{ $album->likes->count() }}</span>
                            </button>
                        @endauth
                    </div>

                    <div class="album-detail-content">
                        <div class="album-detail-heading">
                            <div>
                                <p class="album-detail-kicker">{{ $album->artiste->nom }} · {{ $album->annee ?? 'Album' }}</p>
                                <h1 class="album-detail-title">{{ $album->titre }}</h1>
                            </div>
                            @auth
                                <a class="btn btn-secondary album-edit-link" href="{{ route('albums.edit', $album) }}">Modifier</a>
                                <button
                                    class="fan-button"
                                    id="bouton-fan"
                                    type="button"
                                    data-artiste-id="{{ $album->artiste->id }}"
                                    aria-pressed="{{ $album->artiste->estFanPar(auth()->id()) ? 'true' : 'false' }}"
                                >
                                    @if ($album->artiste->estFanPar(auth()->id()))
                                        ★ Je suis fan
                                    @else
                                        ☆ Je suis fan
                                    @endif
                                    <span id="compteur-fan">{{ $album->artiste->fans->count() }}</span>
                                </button>
                            @endauth
                        </div>

                        <h2 class="tracklist-title">Tracklist</h2>
                        @if ($album->morceaux->count() > 0)
                            <ol class="tracklist">
                                @foreach ($album->morceaux as $morceau)
                                    <li class="track">
                                        <span class="track-number">{{ $morceau->numero }}</span>
                                        <span>{{ $morceau->titre }}</span>
                                        <span class="track-duration">{{ $morceau->duree_formatee ?? '--:--' }}</span>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-muted">Aucun morceau ajouté pour cet album.</p>
                        @endif
                    </div>
                </div>

                @if ($album->description)
                    <p class="album-description">{{ $album->description }}</p>
                @endif
            </section>

            <section class="reviews" id="avis">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Avis</h2>
                        <p class="review-average">Note moyenne : {{ $album->critiques->count() ? number_format($album->note_moyenne, 1) : '0.0' }} / 5</p>
                    </div>
                    @auth
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('form-critique').hidden = !document.getElementById('form-critique').hidden">Ajouter un avis</button>
                    @endauth
                </div>

                @auth
                    <form class="review-form" id="form-critique" method="POST" action="{{ route('critiques.store') }}" hidden>
                        @csrf
                        <input type="hidden" name="album_id" value="{{ $album->id }}">
                        <label for="etoiles-notation">Ta note</label>
                        <div id="etoiles-notation" class="rating-picker" aria-label="Choisir une note">
                            @for ($i = 1; $i <= 5; $i++)
                                <button class="etoile" type="button" data-valeur="{{ $i }}">
                                    <img src="{{ asset('assets/star-full.svg') }}" alt="{{ $i }} étoile{{ $i > 1 ? 's' : '' }}">
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="note" id="note-input" value="0">
                        <textarea name="avis" placeholder="Écris ton avis..."></textarea>
                        <button class="btn btn-primary" type="submit">Publier l'avis</button>
                    </form>
                @endauth

                @forelse ($album->critiques as $critique)
                    <article class="review">
                        <div class="review-avatar">{{ strtoupper(substr($critique->user->name, 0, 1)) }}</div>
                        <div class="review-body">
                            <div class="review-header">
                                <strong class="review-author">{{ $critique->user->name }}</strong>
                                <span class="review-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $critique->note ? '' : 'empty' }}">★</span>
                                    @endfor
                                </span>
                            </div>
                            @if ($critique->avis)
                                <p class="review-text">{{ $critique->avis }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="text-muted">Aucun avis pour le moment.</p>
                @endforelse
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

    <script>
        const etoiles = document.querySelectorAll('.etoile');
        const noteInput = document.getElementById('note-input');

        function afficherEtoiles(note) {
            etoiles.forEach(function (etoile) {
                const valeur = parseInt(etoile.dataset.valeur);
                const image = etoile.querySelector('img');
                const estDemi = valeur - 0.5 === Number(note);
                const estRemplie = valeur <= Number(note);

                etoile.classList.toggle('empty', !estRemplie && !estDemi);
                etoile.classList.toggle('half', estDemi);
                image.src = estDemi
                    ? '{{ asset('assets/star-half.svg') }}'
                    : '{{ asset('assets/star-full.svg') }}';
            });
        }

        etoiles.forEach(function (etoile) {
            etoile.addEventListener('mousemove', function (event) {
                const rect = etoile.getBoundingClientRect();
                const valeurBase = parseInt(etoile.dataset.valeur);
                const valeur = event.clientX - rect.left < rect.width / 2 ? valeurBase - 0.5 : valeurBase;

                afficherEtoiles(valeur);
            });

            etoile.addEventListener('click', function (event) {
                const rect = etoile.getBoundingClientRect();
                const valeurBase = parseInt(etoile.dataset.valeur);
                noteInput.value = event.clientX - rect.left < rect.width / 2 ? valeurBase - 0.5 : valeurBase;
                afficherEtoiles(noteInput.value);
            });
        });

        const notation = document.getElementById('etoiles-notation');
        if (notation) {
            notation.addEventListener('mouseleave', function () {
                afficherEtoiles(parseFloat(noteInput.value));
            });
        }

        afficherEtoiles(parseFloat(noteInput.value));

        const boutonLike = document.getElementById('bouton-like');
        if (boutonLike) {
            boutonLike.addEventListener('click', function () {
                fetch('/likes/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ album_id: boutonLike.dataset.albumId }),
                }).then(response => response.json()).then(data => {
                    boutonLike.textContent = data.liked ? '♥ ' + data.total : '♡ ' + data.total;
                });
            });
        }

        const boutonFan = document.getElementById('bouton-fan');
        if (boutonFan) {
            boutonFan.addEventListener('click', function () {
                fetch('/fans/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ artiste_id: boutonFan.dataset.artisteId }),
                }).then(response => response.json()).then(data => {
                    boutonFan.innerHTML = (data.estFan ? '★ Je suis fan' : '☆ Je suis fan') + ' <span id="compteur-fan">' + data.total + '</span>';
                    boutonFan.setAttribute('aria-pressed', data.estFan ? 'true' : 'false');
                });
            });
        }
    </script>
</body>
</html>
