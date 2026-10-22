<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get('/', function () {
    return redirect()->route('notes.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('notes.index');
    })->name('dashboard');

    Route::resource('notes', NoteController::class);
    Route::get('/notes-archived', [NoteController::class, 'archived'])->name('notes.archived');
    Route::get('/notes-trashed', [NoteController::class, 'trashed'])->name('notes.trashed');
    Route::post('/notes/{note}/pin', [NoteController::class, 'pin'])->name('notes.pin');
    Route::post('/notes/{note}/archive', [NoteController::class, 'archive'])->name('notes.archive');
    Route::post('/notes/{note}/unarchive', [NoteController::class, 'unarchive'])->name('notes.unarchive');
    Route::post('/notes-trashed/{id}/restore', [NoteController::class, 'restore'])->name('notes.restore');
    Route::delete('/notes-trashed/{id}/force', [NoteController::class, 'forceDelete'])->name('notes.forceDelete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
