<article class="artist-card">
    <a href="{{ route('recherche', ['q' => $artiste->nom]) }}">
        @if ($artiste->photo)
            <img class="artist-cover" src="{{ $artiste->photo }}" alt="Photo de {{ $artiste->nom }}">
        @else
            <div class="artist-cover artist-cover-placeholder">No photo</div>
        @endif
        <div class="artist-info">
            <div class="artist-name">{{ $artiste->nom }}</div>
        </div>
    </a>
    @auth
        <a class="artist-edit-link" href="{{ route('artistes.edit', $artiste) }}">Modifier</a>
    @endauth
</article>
