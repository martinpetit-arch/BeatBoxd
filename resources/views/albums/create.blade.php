<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un album - BeatBoxd</title>
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
            <a class="header-button header-button-outline" href="{{ route('profil') }}">Profil</a>
        </div>
    </header>

    <main class="auth-page">
        <div class="auth-container album-edit-form">
            <h1 class="auth-title">Ajouter un album</h1>

            @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('albums.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="titre">Titre</label>
                    <input class="form-input" type="text" id="titre" name="titre" value="{{ old('titre') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="artiste_id">Artiste</label>
                    <select class="form-input" id="artiste_id" name="artiste_id" required>
                        <option value="">Choisir un artiste</option>
                        @foreach ($artistes as $artiste)
                            <option value="{{ $artiste->id }}" @selected(old('artiste_id') == $artiste->id)>{{ $artiste->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="pochette">Pochette (URL)</label>
                    <input class="form-input" type="url" id="pochette" name="pochette" value="{{ old('pochette') }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="annee">Année</label>
                    <input class="form-input" type="number" id="annee" name="annee" value="{{ old('annee') }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-input form-textarea" id="description" name="description">{{ old('description') }}</textarea>
                </div>

                <fieldset class="track-edit-fieldset">
                    <legend>Tracklist</legend>
                    <div id="chansons-container">
                        <input class="form-input" type="text" name="chansons[]" placeholder="Titre du morceau">
                    </div>
                    <button class="btn btn-secondary" type="button" id="ajouter-chanson">+ Ajouter une chanson</button>
                </fieldset>

                <button class="auth-submit btn btn-primary" type="submit">Ajouter l'album</button>
            </form>
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
        document.getElementById('ajouter-chanson').addEventListener('click', function () {
            const input = document.createElement('input');
            input.className = 'form-input';
            input.type = 'text';
            input.name = 'chansons[]';
            input.placeholder = 'Titre du morceau';
            document.getElementById('chansons-container').appendChild(input);
        });
    </script>
</body>
</html>
