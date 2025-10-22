<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TeamsChatNotification;


Route::get('/send-teams', function () {
    $webhook = config('services.microsoft_teams.webhook_url') ?? env('TEAMS_WEBHOOK_URL');

    if (empty($webhook)) {
        return response('Teams webhook is not configured', 500);
    }

    // 簡易なテキスト送信（Incoming Webhook の場合）
    $res = Http::post($webhook, [
        'text' => 'テストメッセージ',
    ]);

    if ($res->successful()) {
        return 'teams notification sent';
    }

    // 失敗時はレスポンス確認
    return response('failed to send: ' . $res->body(), 500);
});

Route::prefix('task')
    ->name('task.')
    ->controller(TaskController::class)
    ->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('store','store')->name('store');
        Route::get('create','create')->name('create');
        Route::get('masterlist','masterlist')->name('masterlist');
        Route::post('masterlist','masterliststore')->name('masterlist.store');
        Route::get('complete/list','completelist')->name('complete.list');
        Route::post('{id}/complete','complete')->name('complete');
        Route::get('{id}','show')->name('show');
        Route::put('{id}','update')->name('update');
        Route::delete('{id}','delete')->name('delete');
        Route::get('{id}/edit','edit')->name('edit');


    });
