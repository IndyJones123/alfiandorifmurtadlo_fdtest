<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('home');
})->name('home');

//Collection Books (Non Aucthentication Users)
Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth','verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Dislike & Like Fitur
    Route::post('/collection/{id}/like', [CollectionController::class, 'like'])->name('collection.like');
    Route::post('/collection/{id}/dislike', [CollectionController::class, 'dislike'])->name('collection.dislike');

    //Users Route
    Route::get('/users', [UserController::class, 'index'])->name('users.index');


    //Books Route
    Route::resource('books', BooksController::class);
});

require __DIR__.'/auth.php';
