<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\PostController;

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
});
