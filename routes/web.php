<?php

use App\Dto\TeamResult;
use App\Http\Controllers\PagesController;
use App\Services\MatchResult;
use App\Services\SeasonDrawService;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {


    $test = new SeasonDrawService();
    $test->drawSeason();

    $tmp = new MatchResult();
    $t = $tmp->calcForWeeks(1);

    dd($t);




    dd(1);


//    return view('welcome');
});

Route::get('/{any?}', [PagesController::class, 'index']);
