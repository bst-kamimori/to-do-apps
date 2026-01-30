<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\CreateRecurringTasksJob;

Schedule::job(new CreateRecurringTasksJob)->everyMinute();
