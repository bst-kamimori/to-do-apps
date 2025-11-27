<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\TaskController;
use App\Notifications\TeamsChatNotification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use Illuminate\Support\Facades\Route;


Route::get('/send-teams', function () {
    Notification::route(MicrosoftTeamsChannel::class, null)
        ->notify(new TeamsChatNotification());
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
        // タスク詳細画面
        Route::post('{id}/complete','complete')->name('complete');
        Route::get('{id}','show')->name('show');
        Route::put('{id}','update')->name('update');
        Route::delete('{id}','delete')->name('delete');
        Route::get('{id}/edit','edit')->name('edit');


    });
// ユーザー認証画
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
