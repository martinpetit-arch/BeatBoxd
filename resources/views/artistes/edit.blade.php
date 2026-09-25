<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier {{ $artiste->nom }} - BeatBoxd</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="auth-page">
        <div class="auth-container">
            <h1 class="auth-title">Modifier l'artiste</h1>

            @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('artistes.update', $artiste) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="nom">Nom</label>
                    <input class="form-input" type="text" id="nom" name="nom" value="{{ old('nom', $artiste->nom) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="photo">Photo (URL)</label>
                    <input class="form-input" type="url" id="photo" name="photo" value="{{ old('photo', $artiste->photo) }}">
                </div>
                <button class="auth-submit btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </main>
</body>
</html>
