<?php

use App\Http\Controllers\MusicController;
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
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [MusicController::class, 'index'])->name('dashboard');
});

/**
 * Integrate lastfm api
 *
 * MusicController
 * MusicRepository -> call Music -> contract ->
 * MusicProvider
 *
 * Service to query the last fm api
 * --------------------------------
 * Last FM Service
 *
 * favourite models
 * ----------------
 * Album Model
 * Artist Model
 *
 * Response collection
 * -------------------
 * AlbumResource
 * ArtistResource
 *
 */

