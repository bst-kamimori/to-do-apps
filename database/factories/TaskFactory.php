<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{

    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->word(),
            'start_date'=>fake()->dateTimeBetween(),
            'end_date'=>fake()->dateTimeBetween(),
            'progress'=>fake()->numberBetween(0, 100),
            'remarks'=>fake()->text(),
            'created_at'=>now(),
            'updated_at'=>now(),
            'operation_id'=>fake()->numberBetween(1, 10),
            'is_completed'=>fake()->numberBetween(0, 1),
        ];
    }
}
