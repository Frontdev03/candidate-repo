<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('authors', UserController::class)->only([
    'show', 'update', 'destroy'
]);

Route::middleware(['auth','verified'])->group(function(){
    Route::post('/delete-books', [UserController::class, 'deleteBooks'])->name('delete-books');
    Route::get('/dashboard',[UserController::class, 'index'])->name('dashboard');
    Route::get('/books', [UserController::class, 'books'])->name('books');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
