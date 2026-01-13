<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnrolmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'module_id' => null,
            'student_id' => null,
            'start_date' => fake()->dateTimeBetween('-120 days', 'now')->format('Y-m-d'),
            'completion_date' => null,
            'status' => 'active',
            'result' => null,
            'result_set_at' => null,
        ];
    }

    public function completed(): static
    {
        $start = fake()->dateTimeBetween('-240 days', '-30 days');
        $complete = (clone $start)->modify('+' . fake()->numberBetween(5, 60) . ' days');

        return $this->state(fn () => [
            'start_date' => $start->format('Y-m-d'),
            'completion_date' => $complete->format('Y-m-d'),
            'status' => 'completed',
            'result' => fake()->randomElement(['PASS', 'FAIL']),
            'result_set_at' => $complete->format('Y-m-d H:i:s'),
        ]);
    }
}
