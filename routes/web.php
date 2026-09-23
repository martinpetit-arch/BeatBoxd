<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', function () {
        return view('blog');
    });

Route::get('/blog', function () {
    return [
        'title ' => 'Mon blog',
        'content' => 'Bienvenue sur mon blog !',
    ];
});

