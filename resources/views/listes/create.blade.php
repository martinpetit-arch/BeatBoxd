<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Créer une liste - BeatBoxd</title>
</head>
<body>
    <p><a href="{{ route('home') }}">Retour à l'accueil</a></p>
    <h1>Créer une liste personnalisée</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('listes.store') }}">
        @csrf

        <p>
            <label for="nom">Nom de la liste</label><br>
            <input id="nom" name="nom" value="{{ old('nom') }}" required maxlength="255">
        </p>

        <p>
            <label for="description">Description</label><br>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </p>

        <fieldset>
            <legend>Albums</legend>
            @forelse ($albums as $album)
                <label style="display: block; margin-bottom: 6px;">
                    <input type="checkbox" name="albums[]" value="{{ $album->id }}">
                    {{ $album->titre }} — {{ $album->artiste->nom }}
                </label>
            @empty
                <p>Aucun album disponible.</p>
            @endforelse
        </fieldset>

        <button type="submit">Créer la liste</button>
    </form>
</body>
</html>
