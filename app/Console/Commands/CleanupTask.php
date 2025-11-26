<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CleanupTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:cleanup {--days=30} {--dry-run}';
    protected $description = '完了済みかつ期限が指定日数より古いタスクを削除する。--dry-runで削除せず一覧表示する。';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $dryrun = (bool) $this->option('dry-run');

        $cutoff = Carbon::now()->subDays($days);

        // end_dateがNULLのものを除外し、期限がカットオフより前の完了タスクを対象にする
        $query = Task::where('is_completed', true)
            ->whereNotNull('end_date')
            ->where('end_date', '<', $cutoff);

        $count = $query->count();

        if($count === 0) {
            $this->info("対象なし：完了かつ更新日 < {$cutoff->toDateString()}>");
            return 0;
        }

        $this->info("削除対象タスク数：{$count}（期限<{$cutoff->toDateString()}）");

        if($dryrun) {
            $rows = $query->orderBy('end_date')
                ->get(['id','name','operation_id','start_date','end_date'])
                ->map(function($task){
                    return [
                        'id' => $task->id,
                        'name' => $task->name,
                        'operation_id' => $task->operation_id,
                        'start_date' => $task->start_date?->toDateString(),
                        'end_date' => $task->end_date?->toDateString(),
                    ];
                })->toArray();

            $this->table(['id','name','operation_id','start_date','end_date'], $rows);
            $this->info('dry-runのため削除は行いません。');
            return 0;
        }

        $deleted = 0;

        DB::transaction(function() use (&$deleted, $query) {
            $query->orderBy('id')->chunkById(100,function($tasks) use (&$deleted){
                foreach($tasks as $task) {
                    $task->delete();
                    $deleted++;
                }
            });
        });

        $this->info("完了 {$deleted} 件を削除しました。");
        return 0;

    }
}
