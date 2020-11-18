<?php

namespace App\Services;

use App\Contracts\SeasonDraw;
use App\Models\Rank;
use App\Models\Result;
use App\Models\Team;
use App\Services\SeasonDraw\StabSeasonDraw;
use Illuminate\Support\Collection;

class SeasonDrawService
{
    private $drawer;
    private $teams;

    public function __construct(SeasonDraw $drawer = null, Collection $teams = null)
    {
        $this->drawer = $drawer ?? new StabSeasonDraw();
        $this->teams = $teams ?? collect([1, 2, 3, 4]);
    }

    public function drawSeason()
    {
        Result::query()->truncate();
        Rank::query()->truncate();

//        $teams = Team::query()->get();
//        foreach ($teams as $team) {
//            Rank::query()->insert(['team_id' => $team->id]);
//        }

        $currentSeason = [];
        foreach ($this->drawer->generate() as $seasonWeek => $matches) {
            foreach ($matches as $pair) {
                $currentSeason[] = [
                    'week' => $seasonWeek,
                    'home_team_id' => $pair[0],
                    'away_team_id' => $pair[1],
                ];
            }
        }

        Result::query()->insert($currentSeason);
    }
}
