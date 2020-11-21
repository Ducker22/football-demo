<?php

use App\Dto\TeamResult;
use App\Http\Controllers\PagesController;
use App\Services\MatchResult;
use App\Services\Predictors\MonteCarloPredictor;
use App\Services\SeasonDrawService;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {

    $arr = [];

    $tmp = $arr['a'] += 1;

    dd($tmp, $arr);
//
    $test = (new MonteCarloPredictor())->test();



    dd($test);


    $test = new SeasonDrawService();
    $test->drawSeason();

    $tmp = new MatchResult();
    $t = $tmp->calcForWeeks(1);

    dd($t);




    dd(1);


//    return view('welcome');
});

Route::get('/{any?}', [PagesController::class, 'index']);
