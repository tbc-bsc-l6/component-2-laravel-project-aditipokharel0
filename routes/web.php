<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\EnrolmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::get('/admin/users', function () {
        return view('admin.users.index', [
            'users' => \App\Models\User::orderBy('name')->get(),
        ]);
    })->name('admin.users.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/teacher/modules', function () {
        return view('teacher.modules.index', [
            'modules' => \App\Models\Module::where('teacher_id', auth()->id())->get(),
        ]);
    })->name('teacher.modules.index');

    Route::get('/catalog', function () {
        return view('student.catalog.index', [
            'modules' => \App\Models\Module::where('is_active', true)->get(),
        ]);
    })->name('student.catalog.index');

    Route::get('/my-enrolments', function () {
        return view('student.enrolments.index');
    })->name('student.enrolments.index');

    Route::get('/history', function () {
        return view('student.history.index');
    })->name('student.history.index');

    Route::post('/modules/{module}/enrol', [EnrolmentController::class, 'store'])
        ->name('modules.enrol');
});
