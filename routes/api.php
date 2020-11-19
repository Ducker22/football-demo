<?php

use App\Http\Controllers\Api\RankController;
use App\Http\Controllers\Api\ResultController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function() {

    Route::get('results', [ResultController::class, 'index']);
    Route::post('results', [ResultController::class, 'calcMatch']);

    Route::post('reset', [ResultController::class, 'draw']);

    Route::get('ranks', [RankController::class, 'index']);
});
