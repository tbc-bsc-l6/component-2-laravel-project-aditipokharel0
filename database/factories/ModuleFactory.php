<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => 'MOD-' . fake()->unique()->numerify('####'),
            'title' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(14),
            'is_active' => fake()->boolean(80),
            'teacher_id' => null,
        ];
    }
}
