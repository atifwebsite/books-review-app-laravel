<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('/');

Route::get('/book/{id}',[HomeController::class,'details'])->name('book.details');
Route::post('/saveReview',[HomeController::class,'saveReview'])->name('book.saveReview');



Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('register', [AccountController::class, 'register'])->name('account.register');
        Route::post('register', [AccountController::class, 'processRegister'])->name('account.processRegister');
        Route::get('login', [AccountController::class, 'login'])->name('account.login');
        Route::post('login', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('logout', [AccountController::class, 'logout'])->name('account.login');
        Route::post('updateprofile', [AccountController::class, 'updateprofile'])->name('account.updateprofile');
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('books/store', [BookController::class, 'store'])->name('books.store');
        Route::get('book_status_active_deactive/{id}', [BookController::class, 'book_status_active_deactive'])->name('books.book_status_active_deactive');
        Route::get('books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
        Route::post('books/update/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('delete', [BookController::class, 'delete'])->name('books.delete');
        Route::get('reviews', [ReviewController::class, 'index'])->name('account.reviews');


    });
});

