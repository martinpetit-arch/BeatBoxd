<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CritiqueController;
use App\Http\Controllers\FanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RechercheController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('inscription');
Route::post('/inscription', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('connexion');
Route::post('/connexion', [AuthController::class, 'login']);
Route::get('/recherche', [RechercheController::class, 'index'])->name('recherche');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');

    Route::post('/critiques', [CritiqueController::class, 'store'])->name('critiques.store');
    Route::post('/likes/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::post('/fans/toggle', [FanController::class, 'toggle'])->name('fans.toggle');
    Route::get('/artistes/create', [ArtisteController::class, 'create'])->name('artistes.create');
    Route::post('/artistes', [ArtisteController::class, 'store'])->name('artistes.store');
    Route::get('/artistes/{artiste}/edit', [ArtisteController::class, 'edit'])->name('artistes.edit');
    Route::put('/artistes/{artiste}', [ArtisteController::class, 'update'])->name('artistes.update');

    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');

    Route::get('/listes/create', [ListeController::class, 'create'])->name('listes.create');
    Route::post('/listes', [ListeController::class, 'store'])->name('listes.store');
    Route::post('/listes/{liste}/albums', [ListeController::class, 'addAlbum'])->name('listes.albums.add');
    Route::delete('/listes/{liste}/albums/{album}', [ListeController::class, 'removeAlbum'])->name('listes.albums.remove');
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

Route::get('/listes', [ListeController::class, 'index'])->name('listes.index');
Route::get('/listes/{liste}', [ListeController::class, 'show'])->name('listes.show');
Route::get('/artistes', [ArtisteController::class, 'index'])->name('artistes.index');
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');
