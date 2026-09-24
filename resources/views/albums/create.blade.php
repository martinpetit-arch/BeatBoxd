<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un album - BeatBoxd</title>
</head>
<body>
    <h1>Ajouter un album</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/albums">
        @csrf

        <label>Titre :</label>
        <input type="text" name="titre" value="{{ old('titre') }}"><br>

        <label>Artiste :</label>
        <select name="artiste_id">
            @foreach ($artistes as $artiste)
                <option value="{{ $artiste->id }}">{{ $artiste->nom }}</option>
            @endforeach
        </select><br>

        <label>Pochette (URL, optionnel) :</label>
        <input type="text" name="pochette" value="{{ old('pochette') }}"><br>

        <label>Année :</label>
        <input type="number" name="annee" value="{{ old('annee') }}"><br>

        <label>Description :</label><br>
        <textarea name="description">{{ old('description') }}</textarea><br>

        <hr>

        <h3>Tracklist</h3>
        <div id="chansons-container">
            <div class="chanson-ligne">
                <label>Chanson n°1 :</label>
                <input type="text" name="chansons[]">
            </div>
        </div>

        <button type="button" id="ajouter-chanson">+ Ajouter une chanson</button>

        <hr>

        <button type="submit">Ajouter l'album</button>
    </form>

    <script>
        let compteur = 1;

        document.getElementById('ajouter-chanson').addEventListener('click', function () {
            compteur++;

            const container = document.getElementById('chansons-container');

            const nouvelleLigne = document.createElement('div');
            nouvelleLigne.className = 'chanson-ligne';
            nouvelleLigne.innerHTML = `
                <label>Chanson n°${compteur} :</label>
                <input type="text" name="chansons[]">
            `;

            container.appendChild(nouvelleLigne);
        });
    </script>
</body>
</html>