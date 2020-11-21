<?php

namespace App\Services;

use App\Contracts\PredictContract;
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
        return $this->predictor->predict();
    }

    public function test()
    {
        return $this->predictor->predict();
    }
}
