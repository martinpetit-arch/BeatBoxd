<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recherche - BeatBoxd</title>
</head>
<body>
    <h1>Recherche</h1>

    <form method="GET" action="/recherche">
        <input type="text" name="q" value="{{ old('q', $terme) }}" placeholder="Rechercher un album, artiste ou morceau">
        <button type="submit">Rechercher</button>
    </form>

    @if ($terme !== '')
        <h2>Résultats pour "{{ $terme }}"</h2>

        <h3>Albums ({{ $albums->count() }})</h3>
        @if ($albums->count() > 0)
            <ul>
                @foreach ($albums as $album)
                    <li>
                        <a href="/albums/{{ $album->id }}">
                            {{ $album->titre }} — {{ $album->artiste?->nom ?? 'Artiste inconnu' }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun album trouvé.</p>
        @endif

        <h3>Artistes ({{ $artistes->count() }})</h3>
        @if ($artistes->count() > 0)
            <ul>
                @foreach ($artistes as $artiste)
                    <li>{{ $artiste->nom }}</li>
                @endforeach
            </ul>
        @else
            <p>Aucun artiste trouvé.</p>
        @endif

        <h3>Morceaux ({{ $morceaux->count() }})</h3>
        @if ($morceaux->count() > 0)
            <ul>
                @foreach ($morceaux as $morceau)
                    <li>
                        <a href="/albums/{{ $morceau->album_id }}">
                            {{ $morceau->titre }} — {{ $morceau->album?->artiste?->nom ?? 'Artiste inconnu' }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun morceau trouvé.</p>
        @endif
    @endif

    <p><a href="/">Retour à l'accueil</a></p>
</body>
</html>