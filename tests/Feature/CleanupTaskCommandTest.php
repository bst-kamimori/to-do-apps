<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use Carbon\Carbon;

class CleanupTaskCommandTest extends TestCase
{
    use RefreshDatabase;
    public function setup(): void
    {
        parent::setup();
        // テスト日程を固定
        Carbon::setTestNow(Carbon::create(2025, 11, 19, 0, 0, 0));
    }

    protected function tearDown(): void
    {
        // テスト日程の固定を解除
        Carbon::setTestNow();
        parent::tearDown();
    }

    //dry_runの一覧表示
    public function test_dry_run()
    {
        // $catoffはnow()-30日 = 2025/11/18-30日 = 2025/10/20
        $toBeDeleted = Task::create(['name' => 'old', 'is_completed' => true, 'end_date' => '2025-10-01']);
        $boundary = Task::create(['name' => 'boundary', 'is_completed' => true, 'end_date' => '2022-10-20']);
        $nullEndDate = Task::create(['name' => 'null', 'is_completed' => true, 'end_date' => 'null']);
        $notCompleted = Task::create(['name' => 'not_completed', 'is_completed' => false, 'end_date' => '2022-09-01']);

        $this->artisan('cleanup:tasks --dry-run')
            ->assertExitCode(0);

        // dry-runのため削除されていないこと
        $this->assertDatabaseHas('tasks', ['id' => $toBeDeleted->id]);
        $this->assertDatabaseHas('tasks', ['id' => $boundary->id]);
        $this->assertDatabaseHas('tasks', ['id' => $nullEndDate->id]);
        $this->assertDatabaseHas('tasks', ['id' => $notCompleted->id]);
    }

    //対象の削除実行
    public function test_delete()
    {
        $toBeDeleted = Task::create(['name' => 'old', 'is_completed' => true, 'end_date' => '2025-10-01']);
        $boundary = Task::create(['name' => 'boundary', 'is_completed' => true, 'end_date' => '2022-10-20']);
        $nullEndDate = Task::create(['name' => 'null', 'is_completed' => true, 'end_date' => 'null']);
        $notCompleted = Task::create(['name' => 'not_completed', 'is_completed' => false, 'end_date' => '2022-09-01']);

        $this->artisan('cleanup:tasks')
            ->assertExitCode(0);

        $this->assertDatabaseHas('tasks', ['id' => $toBeDeleted->id]);
        $this->assertDatabaseHas('tasks', ['id' => $boundary->id]);
        $this->assertDatabaseHas('tasks', ['id' => $nullEndDate->id]);
        $this->assertDatabaseHas('tasks', ['id' => $notCompleted->id]);

    }


}
