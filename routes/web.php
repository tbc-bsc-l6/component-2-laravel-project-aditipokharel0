<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\EnrolmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Module;
use App\Models\Enrolment;

// Redirect root route based on authentication status
// Authenticated users go to dashboard, others to login page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
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

    Route::post('/admin/teachers', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'teacher',
        ]);

        return back()->with('success', 'Teacher created.');
    })->name('admin.teachers.store');

    Route::delete('/admin/teachers/{user}', function (User $user) {
        if (($user->role ?? 'student') !== 'teacher') {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot remove your own account.');
        }

        Module::where('teacher_id', $user->id)->update(['teacher_id' => null]);

        $user->delete();

        return back()->with('success', 'Teacher removed.');
    })->name('admin.teachers.destroy');

    Route::delete('/admin/modules/{module}/enrolments/{enrolment}', function (Module $module, Enrolment $enrolment) {
        if ($enrolment->module_id !== $module->id) {
            abort(404);
        }

        if ($enrolment->status !== 'active') {
            return back()->with('error', 'Only active enrolments can be removed.');
        }

        $enrolment->delete();

        return back()->with('success', 'Student removed from module.');
    })->name('admin.modules.enrolments.destroy');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/modules', function () {
        $user = auth()->user();

        $modules = Module::where('teacher_id', $user->id)
            ->orderBy('code')
            ->get();

        return view('teacher.modules.index', compact('modules'));
    })->name('teacher.modules.index');

    Route::get('/modules/{module}/students', function (Module $module) {
        $user = auth()->user();

        if ($module->teacher_id !== $user->id) {
            abort(403);
        }

        $enrolments = Enrolment::with('student')
            ->where('module_id', $module->id)
            ->where('status', 'active')
            ->get();

        return view('teacher.modules.students', compact('module', 'enrolments'));
    })->name('teacher.modules.students');

    Route::post('/enrolments/{enrolment}/mark', function (Request $request, Enrolment $enrolment) {
        $user = auth()->user();

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
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/catalog', function (Request $request) {
        $q = trim((string) $request->query('q', ''));
        $teacher = $request->query('teacher');

        $modulesQuery = Module::query()->where('is_active', true);

        if ($q !== '') {
            $modulesQuery->where(function ($qq) use ($q) {
                $qq->where('code', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($teacher) {
            $modulesQuery->where('teacher_id', $teacher);
        }

        $modules = $modulesQuery
            ->orderBy('code')
            ->paginate(12)
            ->withQueryString();

        $teachers = User::where('role', 'teacher')->orderBy('name')->get();

        return view('student.catalog.index', compact('modules', 'teachers', 'q', 'teacher'));
    })->name('student.catalog.index');

    Route::get('/catalog/{module}', function (Module $module) {
        if (!$module->is_active) {
            abort(404);
        }

        return view('student.catalog.show', compact('module'));
    })->name('student.catalog.show');

    Route::post('/modules/{module}/enrol', [EnrolmentController::class, 'store'])
        ->name('modules.enrol');

    Route::get('/my-enrolments', function () {
        $user = auth()->user();

        $enrolments = Enrolment::with('module')
            ->where(function ($q) use ($user) {
                $q->where('student_id', $user->id);

                if (Schema::hasColumn('enrolments', 'user_id')) {
                    $q->orWhere('user_id', $user->id);
                }
            })
            ->where('status', 'active')
            ->orderByDesc('start_date')
            ->get();

        return view('student.enrolments.index', compact('enrolments'));
    })->name('student.enrolments.index');
});

Route::middleware(['auth', 'role:student,old_student'])->group(function () {
    Route::get('/history', function () {
        $user = auth()->user();

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
});
