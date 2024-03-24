<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\App;
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

Route::get('/', fn () => redirect()->route('login'))->name('home');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class);
    Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');

    Route::post('{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::post('/change-lang/{lang}', fn ($lang) => session()->put('lang', $lang))->name('change-lang');

Route::get('/login/{type}', [SocialLoginController::class, 'redirectToLogin'])->name('auth.social');
Route::get('/login/{type}/callback', [SocialLoginController::class, 'handleLoginCallback']);

require __DIR__.'/auth.php';
