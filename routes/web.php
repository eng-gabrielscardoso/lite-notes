<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedNoteController;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/notes', NoteController::class);

    Route::get('/trash', [TrashedNoteController::class, 'index'])->name('trash.index');
    Route::get('/trash/{note}', [TrashedNoteController::class, 'show'])->withTrashed()->name('trash.show');
    Route::put('/trash/{note}', [TrashedNoteController::class, 'update'])->withTrashed()->name('trash.update');
});

require __DIR__.'/auth.php';
