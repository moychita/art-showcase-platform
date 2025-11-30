<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT CONTROLLERS (Sesuai Folder) ---

// Guest / Public
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\AuthController;
use App\Http\Controllers\Guest\ArtworkController;
use App\Http\Controllers\Guest\ProfileController;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;

// Curator
use App\Http\Controllers\Curator\CuratorController;

// Member
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\CommentController;
use App\Http\Controllers\Member\LikeController;
use App\Http\Controllers\Member\FavoriteController;
use App\Http\Controllers\Member\ReportController;
use App\Http\Controllers\Guest\ChallengeController;


// =========================================================================
// ROUTES
// =========================================================================

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Halaman Pending Curator
Route::get('/curator/pending', function () {
    return view('curator.pending');
})->name('curator.pending');

// Public Artwork & Profile
Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

// --- AUTHENTICATED ROUTES (Member, Admin, Curator) ---
Route::middleware(['auth'])->group(function () {
    
    // Profile Management
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Interactions
    Route::post('/artworks/{artwork}/like', [LikeController::class, 'toggle'])->name('artworks.like');
    Route::post('/artworks/{artwork}/favorite', [FavoriteController::class, 'toggle'])->name('artworks.favorite');
    Route::post('/artworks/{artwork}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Reporting
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    // Member Dashboard
    Route::middleware(['isMember'])->prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/my-artworks', [MemberController::class, 'myArtworks'])->name('artworks');
    });

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // Artwork Management
    Route::get('/artworks/create/new', [ArtworkController::class, 'create'])->name('artworks.create');
    Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::get('/artworks/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artworks.edit');
    Route::put('/artworks/{artwork}', [ArtworkController::class, 'update'])->name('artworks.update');
    Route::delete('/artworks/{artwork}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');
});


// --- CURATOR ROUTES ---
Route::middleware(['auth', 'isCurator'])->prefix('curator')->name('curator.')->group(function () {
    Route::get('/dashboard', [CuratorController::class, 'dashboard'])->name('dashboard');
    
    // Challenge Management
    Route::get('/challenges', [CuratorController::class, 'challenges'])->name('challenges');
    Route::get('/challenges/create', [CuratorController::class, 'createChallenge'])->name('challenges.create');
    Route::post('/challenges', [CuratorController::class, 'storeChallenge'])->name('challenges.store');
    Route::get('/challenges/{challenge}', [CuratorController::class, 'showChallenge'])->name('challenges.show');
    Route::get('/challenges/{challenge}/edit', [CuratorController::class, 'editChallenge'])->name('challenges.edit');
    Route::put('/challenges/{challenge}', [CuratorController::class, 'updateChallenge'])->name('challenges.update');
    Route::post('/challenges/{challenge}/select-winner', [CuratorController::class, 'selectWinner'])->name('challenges.selectWinner');
});


// --- ADMIN ROUTES ---
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');

    // Reports & Moderation
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/{report}/review', [AdminController::class, 'reviewReport'])->name('reports.review');
    Route::post('/artworks/{artwork}/moderate', [AdminController::class, 'moderateArtwork'])->name('artworks.moderate');
    Route::post('/comments/{comment}/moderate', [AdminController::class, 'moderateComment'])->name('comments.moderate');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);
});