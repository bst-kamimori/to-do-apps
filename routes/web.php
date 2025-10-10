<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::prefix('task')
    ->name('task.')
    ->controller(TaskController::class)
    ->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('store','store')->name('store');
        Route::get('create','create')->name('create');
        Route::post('{id}/complete','complete')->name('complete');
        Route::get('{id}','show')->name('show');
        Route::put('{id}','update')->name('update');
        Route::delete('{id}','delete')->name('delete');
        Route::get('{id}/edit','edit')->name('edit');
        Route::get('complete/list','completelist')->name('complete.list');
    });
