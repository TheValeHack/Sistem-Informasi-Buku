<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('restricted', function(){
    return redirect()->route('dashboard')->with('success', 'Anda berusia lebih dari 18 tahun!');
})->middleware('checkage');

Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::controller(LoginRegisterController::class)->middleware('guest')->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
    Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books/create', [BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/update/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/books/update/{id}', [BookController::class, 'update'])->name('books.update');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::delete('/gallery/destroyImage/{id}', [GalleryController::class, 'destroyImage'])->name('gallery.destroyImage');
    Route::get('/gallery/update/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::post('/gallery/update/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::get('/profil', [UserController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [UserController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update/{id}', [UserController::class, 'update'])->name('profil.update');
    Route::delete('/profil/destroy/{id}', [UserController::class, 'destroy'])->name('profil.destroy');
    Route::get('/send-email', [SendEmailController::class, 'index'])->name('email.create');
    Route::post('/send-email', [SendEmailController::class, 'store'])->name('email.store');
});


