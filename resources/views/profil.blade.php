<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil - BeatBoxd</title>
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="header-button header-button-outline" type="submit">Déconnexion</button>
                </form>
                <a class="header-search" href="{{ route('recherche') }}" aria-label="Rechercher">⌕</a>
            </div>
        </div>
    </header>

    <main class="profile-page">
        <div class="container">
            <section class="profile-header">
                <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <h1>{{ $user->name }}</h1>
            </section>

            <section class="profile-shelf">
                <div class="profile-section-heading">
                    <h2>Albums préférés</h2>
                    <form class="profile-add-form" data-kind="album">
                        <select name="id" aria-label="Ajouter un album préféré">
                            <option value="">Ajouter un album</option>
                            @foreach ($albumsDisponibles as $album)
                                @if (! $albumsFavoris->contains('id', $album->id))
                                    <option value="{{ $album->id }}">{{ $album->titre }} — {{ $album->artiste->nom }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
                <div class="profile-favorites-grid">
                    @forelse ($albumsFavoris as $album)
                        <article class="profile-favorite-card">
                            <a href="{{ route('albums.show', $album->id) }}">
                                @if ($album->pochette)
                                    <img src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
                                @else
                                    <span class="album-cover-placeholder">No cover</span>
                                @endif
                                <strong>{{ $album->titre }}</strong>
                            </a>
                            <button class="favorite-remove" type="button" data-kind="album" data-id="{{ $album->id }}">Retirer</button>
                        </article>
                    @empty
                        <p class="text-muted">Aucun album préféré pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="profile-shelf">
                <div class="profile-section-heading">
                    <h2>Artistes préférés</h2>
                    <form class="profile-add-form" data-kind="artiste">
                        <select name="id" aria-label="Ajouter un artiste préféré">
                            <option value="">Ajouter un artiste</option>
                            @foreach ($artistesDisponibles as $artiste)
                                @if (! $artistesFavoris->contains('id', $artiste->id))
                                    <option value="{{ $artiste->id }}">{{ $artiste->nom }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
                <div class="profile-favorites-grid">
                    @forelse ($artistesFavoris as $artiste)
                        <article class="profile-favorite-card">
                            <a href="{{ route('recherche', ['q' => $artiste->nom]) }}">
                                @if ($artiste->photo)
                                    <img src="{{ $artiste->photo }}" alt="Photo de {{ $artiste->nom }}">
                                @else
                                    <span class="artist-cover-placeholder">No photo</span>
                                @endif
                                <strong>{{ $artiste->nom }}</strong>
                            </a>
                            <button class="favorite-remove" type="button" data-kind="artiste" data-id="{{ $artiste->id }}">Retirer</button>
                        </article>
                    @empty
                        <p class="text-muted">Aucun artiste préféré pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="profile-shelf">
                <div class="profile-section-heading">
                    <h2>Mes notes</h2>
                </div>
                <div class="profile-ratings-grid">
                    @forelse ($notes as $critique)
                        <article class="profile-rating-card">
                            <a href="{{ route('albums.show', $critique->album->id) }}">
                                @if ($critique->album->pochette)
                                    <img src="{{ $critique->album->pochette }}" alt="Pochette de {{ $critique->album->titre }}">
                                @else
                                    <span class="album-cover-placeholder">No cover</span>
                                @endif
                                <strong>{{ $critique->album->titre }}</strong>
                            </a>
                            <div class="profile-rating-stars" aria-label="Note {{ $critique->note }} sur 5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $critique->note ? '' : 'empty' }}">★</span>
                                @endfor
                            </div>
                        </article>
                    @empty
                        <p class="text-muted">Tu n’as encore noté aucun album.</p>
                    @endforelse
                </div>
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function toggleFavorite(kind, id) {
            const url = kind === 'album' ? '/likes/toggle' : '/fans/toggle';
            const key = kind === 'album' ? 'album_id' : 'artiste_id';

            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ [key]: id }),
            });
        }

        document.querySelectorAll('.profile-add-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const id = form.elements.id.value;

                if (id) {
                    toggleFavorite(form.dataset.kind, id).then(() => window.location.reload());
                }
            });
        });

        document.querySelectorAll('.favorite-remove').forEach(function (button) {
            button.addEventListener('click', function () {
                toggleFavorite(button.dataset.kind, button.dataset.id).then(() => window.location.reload());
            });
        });
    </script>
</body>
</html>
