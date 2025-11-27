<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjectName;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectName>
 */
class ProjectNameFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ProjectName::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
