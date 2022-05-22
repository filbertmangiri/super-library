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

Route::name('page.')->controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('home', fn () => Redirect::route('page.home'));
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

Route::name('dashboard.')->controller(DashboardController::class)->middleware('auth')->group(function () {
    Route::get('dashboard', 'index')->name('index');
});

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
