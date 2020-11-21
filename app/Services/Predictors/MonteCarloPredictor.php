<?php

namespace App\Services\Predictors;

use App\Contracts\PredictContract;
use App\Models\Rank;
use App\Models\Result;
use App\Models\Team;
use App\Repositories\ShadowPersister;
use App\Services\MatchResult;
use App\Services\ShadowRank;

class MonteCarloPredictor implements PredictContract
{
    const SIMULATIONS_NUMBER = 100;

    private $shadow;
    private $matchResult;
    private $possibleWinners;

    public function __construct()
    {
        $this->shadow = new ShadowRank();
        $persister = (new ShadowPersister())->setShadowRank($this->shadow);

        $this->matchResult = new MatchResult();
        $this->matchResult->setPersister($persister);

        $this->possibleWinners = $this->initPossibleWinners();
    }

    public function predict()
    {
        $sliceRank = $this->sliceRank();
        $weeks = $this->unPlayedWeeks();

        foreach (range(1, self::SIMULATIONS_NUMBER) as $sim) {

            $this->shadow->setClone($sliceRank);
            $this->matchResult->calcForWeeks($weeks);
            $this->possibleWinners[$this->shadow->getWinner()['team_id']]++;
        }

        return Team::query()->get()->each(function(Team $team) {
            $team->chance = $this->possibleWinners[$team->id];
        });
    }

    public function test()
    {
        $sliceRank = $this->sliceRank();
        $weeks = $this->unPlayedWeeks();

        foreach (range(1, self::SIMULATIONS_NUMBER) as $sim) {

            $this->shadow->setClone($sliceRank);
            $this->matchResult->calcForWeeks($weeks);
            $this->possibleWinners[$this->shadow->getWinner()['team_id']]++;
        }

        return Team::query()->get()->each(function(Team $team) {
            $team->chance = $this->toPercentage($this->possibleWinners[$team->id]);
        });
    }

    private function sliceRank(): array
    {
        return Rank::query()->get()->toArray();
    }

    private function unPlayedWeeks(): array
    {
        return Result::query()
            ->select('week')
            ->whereNull('home_team_scored')
            ->distinct()
            ->pluck('week')
            ->toArray();
    }

    private function initPossibleWinners(): array
    {
        return [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
        ];
    }

    private function toPercentage($hits): int
    {
        return (int) $hits / self::SIMULATIONS_NUMBER * 100;
    }
}
