<?php

use  App\Console\Commands\CleanupTask;
use Illuminate\Support\Facades\Artisan;

Artisan::command('task:cleanup {--days=30} {--dry-run}', function () {
    $command = app(CleanupTask::class);
    $command->setLaravel(app());

    return $command->run($this->input,$this->output);
})->purpose('完了済みで指定日数より古いタスクを削除する（--dry-runは一覧表示）');
