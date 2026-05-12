<?php

use Illuminate\Support\Facades\Route;

// Page d'accueil (Blade)
Route::get('/', function () {
    return view('welcome');
});

// Application React (tout le reste)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$'); // Exclure les routes API