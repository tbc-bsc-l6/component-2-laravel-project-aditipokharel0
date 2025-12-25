<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\EnrolmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Module;

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

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::patch('/modules/{module}/archive', [ModuleController::class, 'archive'])->name('modules.archive');
    Route::patch('/modules/{module}/unarchive', [ModuleController::class, 'unarchive'])->name('modules.unarchive');
    Route::resource('modules', ModuleController::class);

    Route::get('/admin/users', function () {
        return view('admin.users.index', [
            'users' => User::orderBy('name')->get(),
        ]);
    })->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', function (Request $request, User $user) {
        $data = $request->validate([
            'role' => 'required|in:admin,teacher,student,old_student',
        ]);

        if (auth()->id() === $user->id() && $data['role'] !== 'admin') {
            return back()->with('error', 'You cannot remove your own admin role.');
        }

        if (($user->role ?? 'student') === 'teacher' && $data['role'] !== 'teacher') {
            Module::where('teacher_id', $user->id)->update(['teacher_id' => null]);
        }

        $user->update(['role' => $data['role']]);

        return back()->with('success', 'Role updated successfully.');
    })->name('admin.users.role');
});

Route::middleware('auth')->group(function () {
    Route::get('/teacher/modules', function () {
        return view('teacher.modules.index', [
            'modules' => Module::where('teacher_id', auth()->id())->get(),
        ]);
    })->name('teacher.modules.index');

    Route::get('/catalog', function () {
        return view('student.catalog.index', [
            'modules' => Module::where('is_active', true)->get(),
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
