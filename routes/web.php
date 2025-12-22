<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Auth;

Route::get('/admin', function () {
    if (!Auth::user()->isAdmin()) {
        abort(403);
    }

    return view('admin.dashboard');
})->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::patch('/modules/{module}/archive', [ModuleController::class, 'archive'])->name('modules.archive');
    Route::patch('/modules/{module}/unarchive', [ModuleController::class, 'unarchive'])->name('modules.unarchive');
    Route::resource('modules', ModuleController::class);
});



