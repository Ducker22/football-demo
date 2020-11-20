<?php

namespace App\Services\Predictors;

use App\Contracts\PredictContract;
use App\Models\Rank;
use App\Models\Team;

class MonteCarloPredictor implements PredictContract
{
    private $shadow;

    public function predict()
    {
        $result = Team::query()->get()->each(function(Team $team) {
            $team->chance = 25;
        });

        return $result;
    }

    public function test()
    {
        $this->shadow = Rank::query()->get()->groupBy('team_id')->toArray();
    }
}
