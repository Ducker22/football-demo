<?php

namespace App\Repositories;

use App\Contracts\PersistContract;
use App\Models\Rank;
use App\Models\Result;
use Illuminate\Support\Collection;

class DbPersist implements PersistContract
{
    public function saveMatchResult(Result $result, array $values)
    {
        $result->home_team_scored = $values['homeScored'];
        $result->away_team_scored = $values['awayScored'];
        $result->save();
    }

    public function getMatchResult(Collection $weeks)
    {
        return Result::query()->whereIn('week', $weeks)->get();
    }

    public function saveRank(array $values, bool $isRevert = false)
    {
        $k = $isRevert ? -1 : 1;
        $ladderRaw = Rank::query()->where('team_id', $values['team_id'])->first();

        $ladderRaw->game_played = $ladderRaw->game_played + $values['game_played'] * $k;
        $ladderRaw->win = $ladderRaw->win + $values['win'] * $k;
        $ladderRaw->loss = $ladderRaw->loss + $values['loss'] * $k;
        $ladderRaw->draw = $ladderRaw->draw + $values['draw'] * $k;
        $ladderRaw->points = $ladderRaw->points + $values['points'] * $k;
        $ladderRaw->goal_diff = $ladderRaw->goal_diff + $values['goal_diff'] * $k;

        $ladderRaw->save();
    }
}
