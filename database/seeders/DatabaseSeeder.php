<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\ProjectName;
use App\Models\Category;
use App\Models\Operation;
use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $projects = ProjectName::factory(10)->create();
        $categories = Category::factory(10)->create();
        $operations = Operation::factory(15)->create();


        Task::factory(30)->create();
    }

}
