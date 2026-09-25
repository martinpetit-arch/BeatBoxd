<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un artiste - BeatBoxd</title>
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
        <div class="auth-container">
            <h1 class="auth-title">Ajouter un artiste</h1>

            @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('artistes.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="nom">Nom</label>
                    <input class="form-input" type="text" id="nom" name="nom" value="{{ old('nom') }}" placeholder="Nom de l'artiste" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="photo">Photo (URL, optionnel)</label>
                    <input class="form-input" type="url" id="photo" name="photo" value="{{ old('photo') }}" placeholder="https://...">
                </div>
                <button class="auth-submit btn btn-primary" type="submit">Ajouter</button>
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
</body>
</html>
