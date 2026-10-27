<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\FrameController;
use App\Http\Controllers\Guest\PhotoboothController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhotoboothController::class, 'landing'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'store'])->name('login.store');
    Route::post('/logout', [AdminLoginController::class, 'destroy'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'can:manage-frames'])->group(function () {
        Route::get('/frames', [FrameController::class, 'index'])->name('frames.index');
        Route::get('/frames/create', [FrameController::class, 'create'])->name('frames.create');
        Route::post('/frames', [FrameController::class, 'store'])->name('frames.store');
        Route::get('/frames/{id}/edit', [FrameController::class, 'edit'])->name('frames.edit');
        Route::put('/frames/{id}', [FrameController::class, 'update'])->name('frames.update');
        Route::delete('/frames/{id}', [FrameController::class, 'destroy'])->name('frames.destroy');
    });
});

Route::prefix('photobooth')->name('photobooth.')->group(function () {
    Route::get('/', [PhotoboothController::class, 'index'])->name('index');
    Route::get('/{frame}/camera', [PhotoboothController::class, 'camera'])->name('camera');
    Route::post('/session', [PhotoboothController::class, 'session'])->name('session');
});
