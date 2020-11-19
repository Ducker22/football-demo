<?php

namespace App\Services;

use App\Models\Rank;

class RankService
{
    public function getRanks()
    {
        return Rank::query()
            ->with(['team'])
            ->orderBy('points', 'desc')
            ->orderBy('win', 'desc')
            ->orderBy('goal_diff', 'desc')
            ->orderBy('team_id')
            ->get();
    }
}
