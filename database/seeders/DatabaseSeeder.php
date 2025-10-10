<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // users
        User::factory(10)->create();

        // sample projects
        Project::query()->create([
            'name' => '社内ポータル刷新',
            'code' => 'PRJ-PORTAL-001',
            'client_name' => '自社',
            'status' => 'active',
            'start_date' => now()->subMonths(1)->toDateString(),
            'end_date' => null,
            'description' => '社内ポータルサイトの刷新プロジェクト',
        ]);

        Project::query()->create([
            'name' => 'ECサイト構築',
            'code' => 'PRJ-EC-2025',
            'client_name' => 'ABC商事',
            'status' => 'on_hold',
            'start_date' => now()->toDateString(),
            'end_date' => null,
            'description' => '新規ECサイトの構築案件',
        ]);

        Project::query()->create([
            'name' => 'モバイルアプリ保守',
            'code' => 'PRJ-MB-OPS',
            'client_name' => 'XYZモバイル',
            'status' => 'completed',
            'start_date' => now()->subMonths(6)->toDateString(),
            'end_date' => now()->subMonth()->toDateString(),
            'description' => 'iOS/Androidアプリの保守対応',
            'is_archived' => true,
        ]);
    }
}
