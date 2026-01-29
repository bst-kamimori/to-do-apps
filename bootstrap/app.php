<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\CreateRecurringTasksJob;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(App\Http\Middleware\AccessLog::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    // 定期タスクの処理時間の指定
    ->withSchedule(function (Schedule $schedule) {
        $schedule->job(new CreateRecurringTasksJob())->dailyAt('12:33');

        $schedule->job(new CreateRecurringTasksJob())->everyMinute();

    })
    ->withCommands()
    ->create();
