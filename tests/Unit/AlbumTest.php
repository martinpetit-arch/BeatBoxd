<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\Critique;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase
{
    public function test_note_moyenne_est_arrondie_a_un_chiffre_apres_la_virgule(): void
    {
        $album = new Album;
        $album->setRelation('critiques', new Collection([
            new Critique(['note' => 5]),
            new Critique(['note' => 4.5]),
        ]));

        $this->assertSame(4.8, $album->note_moyenne);
    }

    public function test_note_moyenne_est_nulle_sans_critique(): void
    {
        $album = new Album;
        $album->setRelation('critiques', new Collection);

        $this->assertNull($album->note_moyenne);
    }
}
