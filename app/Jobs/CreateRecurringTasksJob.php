<?php

namespace App\Jobs;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

// 定期タスクの登録
class CreateRecurringTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle(): void
    {
        $now = Carbon::now();

        // 定期タスクのテンプレートを取得
        $templates = Task::where('is_recurring', true)
            ->whereNotNull('next_run_at')
            ->where('next_run_at', '<=', $now)
            ->get();


        foreach ($templates as $template) {
            DB::transaction(function () use ($template,$now) {
                $new = $template->replicate();
                $new->is_recurring = false;
                $new->recurrence = null;
                $new->next_run_at = null;
                $new->created_at = $now;
                $new->updated_at = $now;
                $new->save();

                $currentNext = Carbon::parse($template->next_run_at);
                // 毎日・毎週の選択
                switch ($template->recurrence) {
                    case 'daily':
                      $template->next_run_at = $currentNext->copy()->addDay();
                      case 'weekly':
                          $template->next_run_at = $currentNext->copy()->addWeek();
                          break;
                          default:
                              $template->next_run_at = null;
                              break;
                }
                $template->save();
            });
        }
    }
}
