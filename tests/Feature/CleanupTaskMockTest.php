<?php
// php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Task;
use Mockery;
use Carbon\Carbon;

/**
 * CleanupTask コマンドのモックテスト
 * @see \App\Console\Commands\CleanupTask
 */
class CleanupTaskMockTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::create(2025, 11, 19, 0, 0, 0));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        Mockery::close();
        parent::tearDown();
    }

    public function test_dry_run()
    {

        $taskMock = Mockery::mock('alias:' . Task::class);

        $taskMock->shouldReceive('where')
            ->once()
            ->with('is_completed', true)
            ->andReturnSelf();

        $taskMock->shouldReceive('whereNotNull')
            ->once()
            ->with('end_date')
            ->andReturnSelf();

        $taskMock->shouldReceive('where')
            ->once()
            ->with('end_date', '<', Mockery::type(Carbon::class))
            ->andReturnSelf();


        $taskMock->shouldReceive('count')
            ->once()
            ->andReturn(2);

        $taskMock->shouldReceive('orderBy')
            ->once()
            ->with('end_date')
            ->andReturnSelf();

        // get() は日付フィールドを Carbon にして返す
        $taskMock->shouldReceive('get')
            ->once()
            ->andReturn(collect([
                (object)[
                    'id' => 1,
                    'name' => 'old',
                    'operation_id' => null,
                    'start_date' => Carbon::parse('2025-01-01'),
                    'end_date' => Carbon::parse('2025-10-01'),
                ],
                (object)[
                    'id' => 2,
                    'name' => 'boundary',
                    'operation_id' => null,
                    'start_date' => Carbon::parse('2022-01-01'),
                    'end_date' => Carbon::parse('2022-10-20'),
                ],
            ]));


        $taskMock->shouldNotReceive('delete');

        Artisan::call('task:cleanup', ['--dry-run' => true]);

        $output = Artisan::output();
        $this->assertStringContainsString('dry-runのため削除は行いません', $output);
    }

    public function test_delete()
    {
        $taskMock = Mockery::mock('alias:' . Task::class);

        $taskMock->shouldReceive('where')
            ->once()
            ->with('is_completed', true)
            ->andReturnSelf();

        $taskMock->shouldReceive('whereNotNull')
            ->once()
            ->with('end_date')
            ->andReturnSelf();

        $taskMock->shouldReceive('where')
            ->once()
            ->with('end_date', '<', Mockery::type(Carbon::class))
            ->andReturnSelf();

        // 削除対象が存在する想定
        $taskMock->shouldReceive('count')
            ->once()
            ->andReturn(2);

        // chunkById を期待し、コールバックにdeleteを持つオブジェクトを渡す
        $taskMock->shouldReceive('orderBy')
            ->once()
            ->with('id')
            ->andReturnSelf();

        // 準備するモックタスク
        $t1 = Mockery::mock();
        $t1->id = 1;
        $t1->shouldReceive('delete')->once()->andReturnTrue();

        $t2 = Mockery::mock();
        $t2->id = 2;
        $t2->shouldReceive('delete')->once()->andReturnTrue();

        $taskMock->shouldReceive('chunkById')
            ->once()
            ->with(100, Mockery::on(function ($callback) use ($t1, $t2) {
                // コマンドと同様にコールバックを実行し、モックタスクを渡す
                $callback(collect([$t1, $t2]));
                return true;
            }));

        Artisan::call('task:cleanup');

        $output = Artisan::output();
        $this->assertStringContainsString('削除しました', $output);
    }
}
