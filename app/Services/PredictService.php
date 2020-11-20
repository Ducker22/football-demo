<?php

namespace App\Services;

use App\Contracts\PredictContract;
use App\Models\Team;
use App\Services\Predictors\MonteCarloPredictor;

class PredictService
{
    private $predictor;

    public function __construct(PredictContract $predictor = null)
    {
        $this->predictor = $predictor ?? new MonteCarloPredictor();
    }

    public function predict()
    {
        $result = Team::query()->get()->each(function(Team $team) {
            $team->chance = 25;
        });

        return $result;
    }

    public function test()
    {
        return $this->predictor->test();
    }
}
