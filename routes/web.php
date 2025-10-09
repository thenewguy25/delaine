<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Admin\ImpersonationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Blog template demo route
Route::get('/blog-demo', function () {
    return view('blog-demo');
})->name('blog-demo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'can:manage users'])->name('admin.')->group(function () {
    // User management routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // User activation routes
    Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');

    // User impersonation routes
    Route::post('users/{user}/impersonate', [ImpersonationController::class, 'start'])->name('users.impersonate');

    // Invitation management routes
    Route::resource('invitations', InvitationController::class);
    Route::post('invitations/{invitation}/resend', [InvitationController::class, 'resend'])->name('invitations.resend');
    Route::post('invitations/{invitation}/extend', [InvitationController::class, 'extend'])->name('invitations.extend');
    Route::post('invitations/bulk-action', [InvitationController::class, 'bulkAction'])->name('invitations.bulk-action');
});

// Impersonation stop route (accessible to anyone during impersonation)
Route::middleware('auth')->post('admin/impersonation/stop', [ImpersonationController::class, 'stop'])->name('admin.impersonation.stop');

require __DIR__ . '/auth.php';
