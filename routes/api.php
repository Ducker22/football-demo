<?php

use App\Http\Controllers\Api\ResultController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function() {

    Route::get('results', [ResultController::class, 'index']);
    Route::post('results', [ResultController::class, 'draw']);
});
