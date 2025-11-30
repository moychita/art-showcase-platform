<?php

use Illuminate\Support\Facades\Route;

// --- 1. GUEST / PUBLIC CONTROLLERS ---
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\AuthController;
use App\Http\Controllers\Guest\ArtworkController;
use App\Http\Controllers\Guest\ProfileController;
use App\Http\Controllers\Guest\ChallengeController;

// --- 2. ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;

// --- 3. CURATOR CONTROLLERS ---
use App\Http\Controllers\Curator\CuratorController;

// --- 4. MEMBER CONTROLLERS ---
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\CommentController;
use App\Http\Controllers\Member\LikeController;
use App\Http\Controllers\Member\FavoriteController;
use App\Http\Controllers\Member\ReportController;


// =========================================================================
// ROUTES
// =========================================================================

// --- ROUTE PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes (Tamu)
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

// Public Content
Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');


// --- SHARED AUTHENTICATED ROUTES (Member, Curator, Admin) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. KARYA SAYA
    Route::get('/my-artworks', [ArtworkController::class, 'myArtworks'])->name('artworks.my');

    // 2. CRUD Karya
    Route::get('/artworks/create/new', [ArtworkController::class, 'create'])->name('artworks.create');
    Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::get('/artworks/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artworks.edit');
    Route::put('/artworks/{artwork}', [ArtworkController::class, 'update'])->name('artworks.update');
    Route::delete('/artworks/{artwork}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');

    // 3. Profil & Akun
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings/account', [ProfileController::class, 'editAccount'])->name('profile.account');
    Route::put('/settings/account', [ProfileController::class, 'updateAccount'])->name('profile.account.update');

    // 4. Interaksi
    Route::post('/artworks/{artwork}/like', [LikeController::class, 'toggle'])->name('artworks.like');
    Route::post('/artworks/{artwork}/favorite', [FavoriteController::class, 'toggle'])->name('artworks.favorite');
    Route::post('/artworks/{artwork}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    // 5. Halaman Favorit
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});


// --- ROLE SPECIFIC ROUTES ---

// MEMBER ONLY
Route::middleware(['auth', 'isMember'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
});

// CURATOR ONLY
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
    
    // Hapus Challenge
    Route::delete('/challenges/{challenge}', [CuratorController::class, 'destroy'])->name('challenges.destroy');
});

// ADMIN ONLY
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


