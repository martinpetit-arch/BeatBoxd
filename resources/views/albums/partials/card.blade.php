<article class="album-card">
    <a href="{{ route('albums.show', $album->id) }}">
        @if ($album->pochette)
            <img class="album-cover" src="{{ $album->pochette }}" alt="Pochette de {{ $album->titre }}">
        @else
            <div class="album-cover album-cover-placeholder">No cover</div>
        @endif
        <div class="album-info">
            <div class="album-title">{{ $album->titre }}</div>
            <div class="album-artist">{{ $album->artiste->nom }}</div>
        </div>
    </a>
</article>
