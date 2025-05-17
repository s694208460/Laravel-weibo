<?php

use App\Http\Controllers\FollowersController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatusesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [StaticPagesController::class, 'home'])->name('home');
Route::get('/about', [StaticPagesController::class, 'about'])->name('about');
Route::get('/help', [StaticPagesController::class, 'help'])->name('help');
Route::get('/signup', [UsersController::class, 'create'])->name('signup');

Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/login', [SessionsController::class, 'store'])->name('login');
Route::delete('/logout', [SessionsController::class, 'destroy'])->name('logout');

Route::resource('/users', UsersController::class);
Route::get('signup/confirm/{token}', [UsersController::class, 'confirmEmail'])->name('confirm_email');

Route::get('password/reset', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordController::class, 'ShowResetForm'])->name('password.reset');
route::post('password/reset', [PasswordController::class, 'reset'])->name('password.update');

Route::resource('statuses', StatusesController::class, ['only' => ['store', 'destroy']]);

Route::get('/users/{user}/followings', [UsersController::class, 'followings'])->name('users.followings');
Route::get('/users/{user}/followers', [UsersController::class, 'followers'])->name('users.followers');
Route::post('/users/followers/{user}', [FollowersController::class, 'store'])->name('followers.store');
Route::delete('/users/followers/{user}', [FollowersController::class, 'destroy'])->name('followers.destroy');
//Route::get('dashboard', function () {
//return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//require __DIR__ . '/settings.php';
//require __DIR__ . '/auth.php';
