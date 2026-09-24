<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\CritiqueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\FanController;
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

    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
    
    Route::post('/critiques', [CritiqueController::class, 'store'])->name('critiques.store');
    Route::post('/likes/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::post('/fans/toggle', [FanController::class, 'toggle'])->name('fans.toggle');
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Artistes
Route::get('/artistes/create', [ArtisteController::class, 'create'])->name('artistes.create');
Route::post('/artistes', [ArtisteController::class, 'store'])->name('artistes.store');

// Albums (attention à l'ordre : /create avant /{id})
Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');