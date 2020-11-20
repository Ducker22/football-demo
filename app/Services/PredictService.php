<?php

namespace App\Services;

use App\Models\Team;

class PredictService
{
    public function predict()
    {
        $result = Team::query()->get()->each(function(Team $team) {
            $team->chance = 25;
        });

        return $result;
    }
}
