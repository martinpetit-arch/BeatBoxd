<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artiste;
use App\Models\Liste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_list_with_albums(): void
    {
        $user = User::factory()->create();
        $artiste = Artiste::create(['nom' => 'Ariana Grande']);
        $album = Album::create([
            'titre' => 'Petal',
            'artiste_id' => $artiste->id,
        ]);

        $response = $this->actingAs($user)->post(route('listes.store'), [
            'nom' => 'Pop favorites',
            'description' => 'Albums pop à écouter.',
            'albums' => [$album->id],
        ]);

        $liste = Liste::first();

        $response->assertRedirect(route('listes.show', $liste));
        $this->assertDatabaseHas('listes', [
            'user_id' => $user->id,
            'nom' => 'Pop favorites',
        ]);
        $this->assertDatabaseHas('album_liste', [
            'liste_id' => $liste->id,
            'album_id' => $album->id,
        ]);
    }

    public function test_list_is_visible_on_homepage(): void
    {
        $user = User::factory()->create();
        $liste = Liste::factory()->for($user)->create(['nom' => 'Mes classiques']);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee($liste->nom);
    }

    public function test_only_the_owner_can_add_an_album(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $liste = Liste::factory()->for($owner)->create();
        $album = Album::create([
            'titre' => 'Petal',
            'artiste_id' => Artiste::create(['nom' => 'Ariana Grande'])->id,
        ]);

        $response = $this->actingAs($otherUser)->post(route('listes.albums.add', $liste), [
            'album_id' => $album->id,
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('album_liste', [
            'liste_id' => $liste->id,
            'album_id' => $album->id,
        ]);
    }
}
