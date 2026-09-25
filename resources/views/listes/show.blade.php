<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $liste->nom }} - BeatBoxd</title>
</head>
<body>
    <p><a href="{{ route('home') }}">Retour à l'accueil</a></p>
    <h1>{{ $liste->nom }}</h1>
    <p>Créée par {{ $liste->user->name }}</p>

    @if ($liste->description)
        <p>{{ $liste->description }}</p>
    @endif

    <h2>Albums de la liste</h2>
    @forelse ($liste->albums as $album)
        <article style="margin-bottom: 16px;">
            <a href="{{ route('albums.show', $album->id) }}">
                @if ($album->pochette)
                    <img src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}" width="100" height="100" style="object-fit: cover; vertical-align: middle;">
                @endif
                {{ $album->titre }} — {{ $album->artiste->nom }}
            </a>

            @auth
                @if (auth()->id() === $liste->user_id)
                    <form method="POST" action="{{ route('listes.albums.remove', [$liste, $album]) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Retirer</button>
                    </form>
                @endif
            @endauth
        </article>
    @empty
        <p>Cette liste ne contient aucun album.</p>
    @endforelse

    @auth
        @if (auth()->id() === $liste->user_id)
            <h2>Ajouter un album</h2>
            @if ($albumsDisponibles->isNotEmpty())
                <form method="POST" action="{{ route('listes.albums.add', $liste) }}">
                    @csrf
                    <select name="album_id" required>
                        <option value="">Choisir un album</option>
                        @foreach ($albumsDisponibles as $album)
                            <option value="{{ $album->id }}">{{ $album->titre }} — {{ $album->artiste->nom }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Ajouter</button>
                </form>
            @else
                <p>Tous les albums sont déjà dans cette liste.</p>
            @endif
        @endif
    @endauth
</body>
</html>
