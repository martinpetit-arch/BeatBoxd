<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un artiste - BeatBoxd</title>
</head>
<body>
    <h1>Ajouter un artiste</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/artistes">
        @csrf

        <label>Nom :</label>
        <input type="text" name="nom" value="{{ old('nom') }}"><br>

        <label>Photo (URL, optionnel) :</label>
        <input type="text" name="photo" value="{{ old('photo') }}"><br>

        <button type="submit">Ajouter</button>
    </form>

    <p><a href="/albums/create">Ajouter un album →</a></p>
</body>
</html>