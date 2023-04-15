<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedNoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::resource('/notes', NoteController::class);

    Route::prefix('/trash')->name('trash.')->group(function () {
        Route::get('/', [TrashedNoteController::class, 'index'])->name('index');
        Route::get('/{note}', [TrashedNoteController::class, 'show'])->withTrashed()->name('show');
        Route::put('/{note}', [TrashedNoteController::class, 'update'])->withTrashed()->name('update');
        Route::delete('/{note}', [TrashedNoteController::class, 'destroy'])->withTrashed()->name('destroy');
    });
});

require __DIR__.'/auth.php';
