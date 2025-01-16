<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\JabatanController;
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

Route::middleware('auth')->group(function () {
    Route::resource('unit', UnitController::class)
        ->except(['show'])
        ->names([
            'index' => 'unit.index',
            'create' => 'unit.create',
            'store' => 'unit.store',
            'edit' => 'unit.edit',
            'update' => 'unit.update',
            'destroy' => 'unit.destroy',
        ]);

    Route::resource('jabatan',JabatanController::class)
        ->except(['show'])
        ->names([
            'index' => 'jabatan.index',
            'create' => 'jabatan.create',
            'store' => 'jabatan.store',
            'edit' => 'jabatan.edit',
            'update' => 'jabatan.update',
            'destroy' => 'jabatan.destroy',
        ]);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
