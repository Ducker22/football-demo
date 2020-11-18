<?php

use App\Dto\TeamResult;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/{any?}', [PagesController::class, 'index']);

Route::get('/', function () {

    $teams = [1, 2, 3, 4];

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
