<!DOCTYPE html>
<html>
<head>
    <title>BeatBoxd</title>
</head>
<body>
    <h1>BeatBoxd</h1>

    <p><a href="/albums/create">Ajouter un album</a> | <a href="/artistes/create">Ajouter un artiste</a></p>

    <h2>Top 3 des meilleurs albums</h2>

    @if ($topAlbums->count() > 0)
        <ol>
            @foreach ($topAlbums as $album)
                <li>
                    <a href="/albums/{{ $album->id }}">
                        {{ $album->titre }} — {{ $album->artiste->nom }}
                    </a>
                    (Note moyenne : {{ number_format($album->critiques_avg_note, 1) }} / 5)
                </li>
            @endforeach
        </ol>
    @else
        <p>Aucun album noté pour le moment.</p>
    @endif

    <h2>Nouveautés de cette semaine</h2>

    @if ($nouveautes->count() > 0)
        <ul>
            @foreach ($nouveautes as $album)
                <li>
                    <a href="/albums/{{ $album->id }}">
                        {{ $album->titre }} — {{ $album->artiste->nom }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun album pour le moment.</p>
    @endif
</body>
</html>