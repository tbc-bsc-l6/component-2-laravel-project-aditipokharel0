<?php

namespace Tests\Feature;

use App\Models\Enrolment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrolmentRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_cannot_have_more_than_four_active_enrolments(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $modules = Module::factory()->count(5)->create(['is_active' => true]);

        foreach ($modules->take(4) as $m) {
            Enrolment::factory()->create([
                'module_id' => $m->id,
                'student_id' => $student->id,
                'status' => 'active',
                'start_date' => now()->toDateString(),
            ]);
        }

        $this->actingAs($student)
            ->post(route('modules.enrol', $modules[4]))
            ->assertRedirect()
            ->assertSessionHas('error', 'You already have 4 active modules.');

        $this->assertDatabaseMissing('enrolments', [
            'module_id' => $modules[4]->id,
            'student_id' => $student->id,
            'status' => 'active',
        ]);
    }

    public function test_module_cannot_exceed_ten_active_students(): void
    {
        $module = Module::factory()->create(['is_active' => true]);
        $students = User::factory()->count(10)->create(['role' => 'student']);

        foreach ($students as $s) {
            Enrolment::factory()->create([
                'module_id' => $module->id,
                'student_id' => $s->id,
                'status' => 'active',
                'start_date' => now()->toDateString(),
            ]);
        }

        $newStudent = User::factory()->create(['role' => 'student']);

        $this->actingAs($newStudent)
            ->post(route('modules.enrol', $module))
            ->assertRedirect()
            ->assertSessionHas('error', 'This module is full (10 active students).');

        $this->assertDatabaseMissing('enrolments', [
            'module_id' => $module->id,
            'student_id' => $newStudent->id,
            'status' => 'active',
        ]);
    }

    public function test_student_cannot_enrol_in_inactive_module(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $module = Module::factory()->create(['is_active' => false]);

        $this->actingAs($student)
            ->post(route('modules.enrol', $module))
            ->assertRedirect()
            ->assertSessionHas('error', 'Module is not available.');

        $this->assertDatabaseMissing('enrolments', [
            'module_id' => $module->id,
            'student_id' => $student->id,
        ]);
    }

    public function test_student_cannot_enrol_in_same_module_twice(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $module = Module::factory()->create(['is_active' => true]);

        Enrolment::factory()->create([
            'module_id' => $module->id,
            'student_id' => $student->id,
            'status' => 'active',
            'start_date' => now()->toDateString(),
        ]);

        $this->actingAs($student)
            ->post(route('modules.enrol', $module))
            ->assertRedirect()
            ->assertSessionHas('error', 'You are already enrolled in this module.');

        $this->assertSame(1, Enrolment::where('module_id', $module->id)->where('student_id', $student->id)->count());
    }
}
