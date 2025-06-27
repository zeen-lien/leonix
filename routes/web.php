<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FolderController;

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
    return view('landing');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes (from Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard search
    Route::get('/search', [DashboardController::class, 'search'])->name('search');
    Route::get('/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');
    
    // Trash Management
    Route::get('/trash', [FileController::class, 'trash'])->name('trash.index');
    Route::post('/trash/empty', [FileController::class, 'emptyTrash'])->name('trash.empty'); // Assuming you'll create this method

    // File Management
    Route::resource('files', FileController::class);
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::get('/files/{file}/preview', [FileController::class, 'preview'])->name('files.preview');
    Route::post('/files/bulk-delete', [FileController::class, 'bulkDelete'])->name('files.bulk-delete');
    Route::post('/files/bulk-download', [FileController::class, 'bulkDownload'])->name('files.bulk-download');
    Route::post('/files/{id}/restore', [FileController::class, 'restore'])->name('files.restore');
    Route::delete('/files/{id}/force-delete', [FileController::class, 'forceDelete'])->name('files.force-delete');

    // Folder Management
    Route::resource('folders', FolderController::class);
    Route::post('/folders/{id}/restore', [FolderController::class, 'restore'])->name('folders.restore');
    Route::delete('/folders/{id}/force-delete', [FolderController::class, 'forceDelete'])->name('folders.force-delete');
});

// Socialite Routes
Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');

// Include admin routes
require __DIR__.'/admin.php';

require __DIR__.'/auth.php';
