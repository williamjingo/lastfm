<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('artists', ArtistController::class)->names([
        'names' => [
            'index' => 'artists.index',
            'store' => 'artists.store',
            'destroy' => 'artists.destroy'
        ]
    ]);

    Route::resource('albums', AlbumController::class)->names([
        'names' => [
            'index' => 'albums.index',
            'store' => 'albums.store',
            'destroy' => 'albums.destroy'
        ]
    ]);

});

