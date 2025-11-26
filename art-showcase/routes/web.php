<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AdminController,
    MemberController,
    CuratorController,
    CategoryController,
    AuthController
};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/curator/pending', function () {
    return view('curator.pending');
})->name('curator.pending');

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/{report}/review', [AdminController::class, 'reviewReport'])->name('reports.review');

    Route::post('/artworks/{artwork}/moderate', [AdminController::class, 'moderateArtwork'])->name('artworks.moderate');
    Route::post('/comments/{comment}/moderate', [AdminController::class, 'moderateComment'])->name('comments.moderate');

    Route::resource('categories', CategoryController::class)->except(['show']);
});

Route::middleware(['auth', 'isMember'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'isCurator'])->prefix('curator')->name('curator.')->group(function () {
    Route::get('/dashboard', [CuratorController::class, 'dashboard'])->name('dashboard');
});