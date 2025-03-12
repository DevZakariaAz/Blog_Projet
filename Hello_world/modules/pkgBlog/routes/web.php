<?php

use Illuminate\Support\Facades\Route;
use Modules\pkgBlog\app\Http\Controllers\BlogController;

Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
});
