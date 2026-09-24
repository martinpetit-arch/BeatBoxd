<!DOCTYPE html>
<html>
<head>
    <title>{{ $album->titre }} - BeatBoxd</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .etoile {
            color: #ccc;
        }

        .etoile.pleine {
            color: gold;
        }
    </style>
</head>
<body>
    <h1>{{ $album->titre }}</h1>

    @if ($album->pochette)
        <img src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}" width="300">
    @endif

    <p>
    Artiste : {{ $album->artiste->nom }}

    @auth
        <button
            id="bouton-fan"
            type="button"
            data-artiste-id="{{ $album->artiste->id }}"
            aria-pressed="{{ $album->artiste->estFanPar(auth()->id()) ? 'true' : 'false' }}"
            style="cursor: pointer; background: none; border: none; padding: 0; color: inherit; font: inherit;"
        >
            @if ($album->artiste->estFanPar(auth()->id()))
                ⭐ Je suis fan ! (<span id="compteur-fan">{{ $album->artiste->fans->count() }}</span>)
            @else
                ☆ Je suis fan ! (<span id="compteur-fan">{{ $album->artiste->fans->count() }}</span>)
            @endif
        </button>
    @endauth
</p>

    @if ($album->annee)
        <p>Année : {{ $album->annee }}</p>
    @endif

    @if ($album->description)
        <p>{{ $album->description }}</p>
    @endif

    <h3>Tracklist</h3>

    <h3>Noter cet album</h3>

    @auth
        <form method="POST" action="/critiques">
            @csrf
            <input type="hidden" name="album_id" value="{{ $album->id }}">

            <label>Note :</label>
            <div id="etoiles-notation" style="font-size: 2em; cursor: pointer;">
                <span class="etoile" data-valeur="1">☆</span>
                <span class="etoile" data-valeur="2">☆</span>
                <span class="etoile" data-valeur="3">☆</span>
                <span class="etoile" data-valeur="4">☆</span>
                <span class="etoile" data-valeur="5">☆</span>
            </div>
            <input type="hidden" name="note" id="note-input" value="0">

            <div id="bouton-like" data-album-id="{{ $album->id }}" style="cursor: pointer; font-size: 1.5em; margin: 10px 0;">
                @if ($album->estLikePar(auth()->id()))
                    ❤️ <span id="compteur-like">{{ $album->likes->count() }}</span>
                @else
                    🤍 <span id="compteur-like">{{ $album->likes->count() }}</span>
                @endif
            </div>

            <label>Avis :</label><br>
            <textarea name="avis"></textarea><br>

            <button type="submit">Envoyer la critique</button>
        </form>
    @else
        <p><a href="/login">Connecte-toi</a> pour noter cet album.</p>
    @endauth

    @if ($album->morceaux->count() > 0)
        <ol>
            @foreach ($album->morceaux as $morceau)
                <li>
                    {{ $morceau->titre }}
                    @if ($morceau->duree_formatee)
                        — {{ $morceau->duree_formatee }}
                    @endif
                </li>
            @endforeach
        </ol>
    @else
        <p>Aucun morceau ajouté pour cet album.</p>
    @endif

    <h3>Critiques ({{ $album->critiques->count() }})</h3>

    @if ($album->critiques->count() > 0)
        <p>Note moyenne : {{ number_format($album->note_moyenne, 1) }} / 5</p>

        @foreach ($album->critiques as $critique)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <strong>{{ $critique->user->name }}</strong> —
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $critique->note)
                        ★
                    @elseif ($i - 0.5 == $critique->note)
                        ⯨
                    @else
                        ☆
                    @endif
                @endfor

                @if ($critique->avis)
                    <p>{{ $critique->avis }}</p>
                @endif
            </div>
        @endforeach
    @else
        <p>Aucune critique pour le moment.</p>
    @endif

    <p><a href="/">Retour à l'accueil</a></p>

    <script>
        const etoiles = document.querySelectorAll('.etoile');
        const noteInput = document.getElementById('note-input');

        etoiles.forEach(function (etoile) {
            etoile.addEventListener('mousemove', function (e) {
                const rect = etoile.getBoundingClientRect();
                const positionSouris = e.clientX - rect.left;
                const moitie = rect.width / 2;

                const valeurBase = parseInt(etoile.dataset.valeur);
                const valeur = positionSouris < moitie ? valeurBase - 0.5 : valeurBase;

                afficherEtoiles(valeur);
            });

            etoile.addEventListener('click', function (e) {
                const rect = etoile.getBoundingClientRect();
                const positionSouris = e.clientX - rect.left;
                const moitie = rect.width / 2;

                const valeurBase = parseInt(etoile.dataset.valeur);
                const valeur = positionSouris < moitie ? valeurBase - 0.5 : valeurBase;

                noteInput.value = valeur;
            });
        });

        document.getElementById('etoiles-notation').addEventListener('mouseleave', function () {
            afficherEtoiles(parseFloat(noteInput.value));
        });

        function afficherEtoiles(note) {
            etoiles.forEach(function (etoile) {
                const valeurEtoile = parseInt(etoile.dataset.valeur);

                if (valeurEtoile <= note) {
                    etoile.textContent = '★';
                } else if (valeurEtoile - 0.5 === note) {
                    etoile.textContent = '⯨';
                } else {
                    etoile.textContent = '☆';
                }
            });
        }

        const boutonLike = document.getElementById('bouton-like');

        if (boutonLike) {
            boutonLike.addEventListener('click', function () {
                const albumId = boutonLike.dataset.albumId;

                fetch('/likes/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ album_id: albumId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.liked) {
                        boutonLike.innerHTML = '❤️ <span id="compteur-like">' + data.total + '</span>';
                    } else {
                        boutonLike.innerHTML = '🤍 <span id="compteur-like">' + data.total + '</span>';
                    }
                });
            });
        }

        const boutonFan = document.getElementById('bouton-fan');

        if (boutonFan) {
            boutonFan.addEventListener('click', function (event) {
                event.preventDefault();
                const artisteId = boutonFan.dataset.artisteId;

                fetch('/fans/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ artiste_id: artisteId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.estFan) {
                        boutonFan.innerHTML = '⭐ Je suis fan ! (<span id="compteur-fan">' + data.total + '</span>)';
                        boutonFan.setAttribute('aria-pressed', 'true');
                    } else {
                        boutonFan.innerHTML = '☆ Je suis fan ! (<span id="compteur-fan">' + data.total + '</span>)';
                        boutonFan.setAttribute('aria-pressed', 'false');
                    }
                });
            });
        }
    </script>
</body>
</html>