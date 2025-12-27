<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EnrolmentController extends Controller
{
    public function store(Request $request, Module $module)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? 'student') !== 'student') {
            abort(403);
        }

        if (!$module->is_active) {
            return back()->with('error', 'Module is not available.');
        }

        $activeCount = Enrolment::where(function ($q) use ($user) {
                $q->where('student_id', $user->id);

                if (Schema::hasColumn('enrolments', 'user_id')) {
                    $q->orWhere('user_id', $user->id);
                }
            })
            ->where('status', 'active')
            ->count();

        if ($activeCount >= 4) {
            return back()->with('error', 'You already have 4 active modules.');
        }

        $moduleActiveStudents = Enrolment::where('module_id', $module->id)
            ->where('status', 'active')
            ->count();

        if ($moduleActiveStudents >= 10) {
            return back()->with('error', 'This module is full (10 active students).');
        }

        $alreadyEnrolled = Enrolment::where('module_id', $module->id)
            ->where(function ($q) use ($user) {
                $q->where('student_id', $user->id);

                if (Schema::hasColumn('enrolments', 'user_id')) {
                    $q->orWhere('user_id', $user->id);
                }
            })
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'You are already enrolled in this module.');
        }

        $data = [
            'student_id' => $user->id,
            'module_id' => $module->id,
            'start_date' => now()->toDateString(),
            'status' => 'active',
        ];

        if (Schema::hasColumn('enrolments', 'user_id')) {
            $data['user_id'] = $user->id;
        }

        Enrolment::create($data);

        return back()->with('success', 'Enrolled successfully.');
    }
}
