<?php

use App\Dto\TeamResult;
use App\Http\Controllers\PagesController;
use App\Services\SeasonDrawService;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {


    $test = new SeasonDrawService();
    $test->drawSeason();

    dd(1);

    $teams = collect([
        [1, 2],
        [3, 4]
    ]);

    dd($teams->flatten());

    function matchRes($teamHome, $teamAway)
    {
        $teamHomeScored = rand(0, 5);
        $teamAwayScored = rand(0, 5);

        $result[] = (new TeamResult($teamHome, $teamHomeScored, $teamAwayScored))->fullStatTransform();
        $result[] = (new TeamResult($teamAway, $teamAwayScored, $teamHomeScored))->fullStatTransform();

        return $result;
    }

    $tmp = matchRes(1, 2);

    dd($tmp);


//    return view('welcome');
});

Route::get('/{any?}', [PagesController::class, 'index']);
