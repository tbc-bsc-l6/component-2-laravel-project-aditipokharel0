<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use App\Models\Module;

class EnrolmentController extends Controller
{
    public function store(Module $module)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'student') {
            abort(403);
        }

        if (!$module->is_active) {
            return back()->with('error', 'Module is not available.');
        }

        $activeCount = Enrolment::where('user_id', $user->id)
            ->whereNull('completion_date')
            ->count();

        if ($activeCount >= 4) {
            return back()->with('error', 'You already have 4 active modules.');
        }

        $moduleActiveStudents = Enrolment::where('module_id', $module->id)
            ->whereNull('completion_date')
            ->count();

        if ($moduleActiveStudents >= 10) {
            return back()->with('error', 'This module is full (10 active students).');
        }

        Enrolment::firstOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['start_date' => now()->toDateString()]
        );

        return back()->with('success', 'Enrolled successfully.');
    }
}
