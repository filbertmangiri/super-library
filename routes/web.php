<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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

Route::get('/', [BookController::class, 'index'])->name('home');

Route::name('page.')->controller(PageController::class)->group(function () {
    Route::get('about', 'about')->name('about');
});

Route::name('auth.')->controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate')->name('login');

        Route::get('register', 'register')->name('register');
        Route::post('register', 'store')->name('register');
    });

    Route::post('logout', 'logout')->name('logout')->middleware('auth');
});

Route::name('dashboard.')->prefix('dashboard')->controller(DashboardController::class)->middleware('isAtLeastModerator')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('book', 'book')->name('book');
    Route::get('category', 'category')->name('category');
    Route::get('author', 'author')->name('author');
    Route::get('review', 'review')->name('review');
    Route::get('user', 'user')->name('user');
    Route::get('moderator', 'moderator')->name('moderator');
});

Route::name('user.')->prefix('user')->controller(UserController::class)->group(function () {
    Route::get('createModerator', 'createModerator')->name('createModerator');
    Route::put('storeModerator', 'storeModerator')->name('storeModerator');
    Route::patch('restore', 'restore')->name('restore');
    Route::delete('forceDelete', 'forceDelete')->name('forceDelete');
    Route::patch('restoreAll', 'restoreAll')->name('restoreAll');
});

Route::resource('user', UserController::class)->parameters([
    'user' => 'user:username'
]);

Route::resource('book', BookController::class)->parameters([
    'book' => 'book:slug'
]);

Route::resource('review', ReviewController::class);

Route::resource('author', AuthorController::class)->parameters([
    'author' => 'author:slug'
]);

Route::resource('category', CategoryController::class)->parameters([
    'category' => 'category:slug'
]);
