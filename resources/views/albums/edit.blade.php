<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier {{ $album->titre }} - BeatBoxd</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="auth-page">
        <div class="auth-container album-edit-form">
            <h1 class="auth-title">Modifier l'album</h1>

            @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('albums.update', $album) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="titre">Titre</label>
                    <input class="form-input" type="text" id="titre" name="titre" value="{{ old('titre', $album->titre) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="artiste_id">Artiste</label>
                    <select class="form-input" id="artiste_id" name="artiste_id" required>
                        @foreach ($artistes as $artiste)
                            <option value="{{ $artiste->id }}" @selected(old('artiste_id', $album->artiste_id) == $artiste->id)>{{ $artiste->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="pochette">Pochette (URL)</label>
                    <input class="form-input" type="url" id="pochette" name="pochette" value="{{ old('pochette', $album->pochette) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="annee">Année</label>
                    <input class="form-input" type="number" id="annee" name="annee" value="{{ old('annee', $album->annee) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-input form-textarea" id="description" name="description">{{ old('description', $album->description) }}</textarea>
                </div>

                <fieldset class="track-edit-fieldset">
                    <legend>Tracklist</legend>
                    <div id="chansons-container">
                        @forelse ($album->morceaux as $morceau)
                            <input class="form-input" type="text" name="chansons[]" value="{{ $morceau->titre }}">
                        @empty
                            <input class="form-input" type="text" name="chansons[]">
                        @endforelse
                    </div>
                    <button class="btn btn-secondary" type="button" id="ajouter-chanson">+ Ajouter une chanson</button>
                </fieldset>

                <button class="auth-submit btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </main>

    <script>
        document.getElementById('ajouter-chanson').addEventListener('click', function () {
            const input = document.createElement('input');
            input.className = 'form-input';
            input.type = 'text';
            input.name = 'chansons[]';
            document.getElementById('chansons-container').appendChild(input);
        });
    </script>
</body>
</html>
