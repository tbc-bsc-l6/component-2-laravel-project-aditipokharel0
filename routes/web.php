<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\EnrolmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Module;
use App\Models\Enrolment;

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

        if (auth()->id() === $user->id && $data['role'] !== 'admin') {
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
        $user = auth()->user();

        if (($user->role ?? 'student') !== 'teacher') {
            abort(403);
        }

        return view('teacher.modules.index', [
            'modules' => Module::where('teacher_id', $user->id)->get(),
        ]);
    })->name('teacher.modules.index');

    Route::get('/teacher/modules/{module}/students', function (Module $module) {
        $user = auth()->user();

        if (($user->role ?? 'student') !== 'teacher') {
            abort(403);
        }

        if ($module->teacher_id !== $user->id) {
            abort(403);
        }

        $enrolments = Enrolment::with('student')
            ->where('module_id', $module->id)
            ->where('status', 'active')
            ->get();

        return view('teacher.modules.students', compact('module', 'enrolments'));
    })->name('teacher.modules.students');

    Route::post('/teacher/enrolments/{enrolment}/mark', function (Request $request, Enrolment $enrolment) {
        $user = auth()->user();

        if (($user->role ?? 'student') !== 'teacher') {
            abort(403);
        }

        $module = Module::findOrFail($enrolment->module_id);

        if ($module->teacher_id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'result' => 'required|in:PASS,FAIL',
        ]);

        $enrolment->update([
            'result' => $data['result'],
            'result_set_at' => now(),
            'completion_date' => now()->toDateString(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Result saved.');
    })->name('teacher.enrolments.mark');

    Route::get('/catalog', function () {
        $user = auth()->user();

        if (($user->role ?? 'student') !== 'student') {
            abort(403);
        }

        return view('student.catalog.index', [
            'modules' => Module::where('is_active', true)->get(),
        ]);
    })->name('student.catalog.index');

    Route::get('/my-enrolments', function () {
        $user = auth()->user();

        if (($user->role ?? 'student') !== 'student') {
            abort(403);
        }

        $enrolments = Enrolment::with('module')
            ->where('status', 'active')
            ->where(function ($q) use ($user) {
                $q->where('student_id', $user->id);

                if (Schema::hasColumn('enrolments', 'user_id')) {
                    $q->orWhere('user_id', $user->id);
                }
            })
            ->orderByDesc('start_date')
            ->get();

        return view('student.enrolments.index', compact('enrolments'));
    })->name('student.enrolments.index');

    Route::get('/history', function () {
        $user = auth()->user();

        if (!in_array(($user->role ?? 'student'), ['student', 'old_student'])) {
            abort(403);
        }

        $enrolments = Enrolment::with('module')
            ->where('status', 'completed')
            ->where(function ($q) use ($user) {
                $q->where('student_id', $user->id);

                if (Schema::hasColumn('enrolments', 'user_id')) {
                    $q->orWhere('user_id', $user->id);
                }
            })
            ->orderByDesc('completion_date')
            ->get();

        return view('student.history.index', compact('enrolments'));
    })->name('student.history.index');

    Route::post('/modules/{module}/enrol', [EnrolmentController::class, 'store'])
        ->name('modules.enrol');
});
