<?php

namespace App\Services\ResultGens;

use App\Contracts\ResultGenerator;

class PlainGen implements ResultGenerator
{
    const HOME_TEAM_WIN_CHANCE = 40;
    const AWAY_TEAM_WIN_CHANCE = 30;

    private $homeTeamScored;
    private $awayTeamScored;

    public function generate(): array
    {
        $rnd = random_int(1, 100);

        if ($rnd <= self::HOME_TEAM_WIN_CHANCE) {
            $this->goalRandomize($this->homeTeamScored, $this->awayTeamScored);
        }

        if ($rnd > self::HOME_TEAM_WIN_CHANCE && $rnd <= self::HOME_TEAM_WIN_CHANCE + self::AWAY_TEAM_WIN_CHANCE) {
            $this->goalRandomize($this->homeTeamScored, $this->awayTeamScored);
        }

        if ($rnd > self::HOME_TEAM_WIN_CHANCE + self::AWAY_TEAM_WIN_CHANCE) {
            $this->goalRandomize($this->homeTeamScored, $this->awayTeamScored, true);
        }

        return [
            'homeScored' => $this->homeTeamScored,
            'awayScored' => $this->awayTeamScored,
        ];
    }

    private function goalRandomize(int &$scoredA, int &$scoredB, bool $isDraw = false): void
    {
        $scoredA = random_int(1, 5);
        $scoredB = $isDraw ? $scoredA : random_int(0, $scoredA - 1);
    }
}