<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - BeatBoxd</title>
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
                <a class="header-button header-button-outline" href="{{ route('login') }}">Connexion</a>
                <a class="header-button header-button-signup" href="{{ route('register') }}">S'inscrire</a>
                <a class="header-search" href="{{ route('recherche') }}" aria-label="Rechercher">⌕</a>
            </div>
        </div>
    </header>

    <main class="auth-page">
        <div class="auth-container">
            <h1 class="auth-title">Reconnecte toi à ton compte</h1>
            <p class="auth-switch">Pas encore de compte ? <a href="{{ route('register') }}">Clique ici !</a></p>

            @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">E-mail</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Jean.dupont@mmibordeaux.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe <small>(minimum 8 caractères)</small></label>
                    <input class="form-input" type="password" id="password" name="password" placeholder="********" required>
                </div>
                <button class="auth-submit btn btn-primary" type="submit">Confirmer</button>
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
