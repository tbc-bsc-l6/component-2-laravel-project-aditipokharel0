<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Module;
use App\Models\Enrolment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $teacher1 = User::updateOrCreate(
            ['email' => 'teacher1@example.com'],
            [
                'name' => 'Teacher One',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        $teacher2 = User::updateOrCreate(
            ['email' => 'teacher2@example.com'],
            [
                'name' => 'Teacher Two',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        $studentDemo = User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        $extraTeachers = User::factory()->count(3)->create(['role' => 'teacher']);
        $teachers = User::where('role', 'teacher')->get();

        $students = User::factory()->count(60)->create(['role' => 'student']);
        $oldStudents = User::factory()->count(20)->create(['role' => 'old_student']);

        $students = $students->push($studentDemo);

        $modules = Module::factory()->count(30)->create();

        foreach ($modules as $m) {
            $m->update([
                'teacher_id' => fake()->boolean(85) ? $teachers->random()->id : null,
            ]);
        }

        $activeModules = $modules->where('is_active', true)->values();
        $allModuleIds = $modules->pluck('id')->values()->all();

        $moduleRemaining = [];
        foreach ($activeModules as $m) {
            $moduleRemaining[$m->id] = 10;
        }

        $used = [];

        foreach ($students as $student) {
            $used[$student->id] = [];

            $target = fake()->numberBetween(0, 4);
            for ($i = 0; $i < $target; $i++) {
                $eligible = [];
                foreach ($moduleRemaining as $moduleId => $remaining) {
                    if ($remaining <= 0) continue;
                    if (in_array($moduleId, $used[$student->id], true)) continue;
                    $eligible[] = $moduleId;
                }

                if (count($eligible) === 0) break;

                $moduleId = $eligible[array_rand($eligible)];

                Enrolment::factory()->create([
                    'module_id' => $moduleId,
                    'student_id' => $student->id,
                    'start_date' => now()->subDays(fake()->numberBetween(0, 40))->format('Y-m-d'),
                    'status' => 'active',
                    'completion_date' => null,
                    'result' => null,
                    'result_set_at' => null,
                ]);

                $moduleRemaining[$moduleId]--;
                $used[$student->id][] = $moduleId;
            }
        }

        foreach ($students as $student) {
            $completedCount = fake()->numberBetween(0, 3);

            for ($i = 0; $i < $completedCount; $i++) {
                $eligible = array_values(array_diff($allModuleIds, $used[$student->id]));
                if (count($eligible) === 0) break;

                $moduleId = $eligible[array_rand($eligible)];

                Enrolment::factory()->completed()->create([
                    'module_id' => $moduleId,
                    'student_id' => $student->id,
                ]);

                $used[$student->id][] = $moduleId;
            }
        }

        foreach ($oldStudents as $student) {
            $used[$student->id] = [];
            $completedCount = fake()->numberBetween(2, 6);

            for ($i = 0; $i < $completedCount; $i++) {
                $eligible = array_values(array_diff($allModuleIds, $used[$student->id]));
                if (count($eligible) === 0) break;

                $moduleId = $eligible[array_rand($eligible)];

                Enrolment::factory()->completed()->create([
                    'module_id' => $moduleId,
                    'student_id' => $student->id,
                ]);

                $used[$student->id][] = $moduleId;
            }
        }
    }
}
