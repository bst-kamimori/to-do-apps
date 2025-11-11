<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjectName;

class ProjectNameFactory extends Factory
{
    protected $model = ProjectName::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
