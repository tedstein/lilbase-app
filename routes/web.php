<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\TableController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/apps', AppController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::prefix('apps/{app}')->group(function () {

    Route::resource('/tables', TableController::class)
        ->only(['index', 'update', 'destroy', 'store'])
        ->middleware(['auth', 'verified']);

    Route::prefix('{table}')->group(function () {

        Route::resource('fields', FieldController::class)
            ->only(['index', 'store', 'destroy', 'update'])
            ->middleware(['auth', 'verified']);

    });

});


require __DIR__ . '/auth.php';
