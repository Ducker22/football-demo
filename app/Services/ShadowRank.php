<?php

namespace App\Services;

use Webmozart\Assert\Assert;

class ShadowRank
{
    /** @var array */
    private $cloneRank;

    public function setClone(array $cloneRank)
    {
        foreach ($cloneRank as $row) {
            $this->cloneRank[$row['team_id']] = $row;
        }
    }

    public function getClone(): array
    {
        return $this->cloneRank;
    }

    public function addGameResult(array $gameResult)
    {
//        Assert::notEmpty($this->cloneRank, 'Rank shadow copy should be set first.');
//        Assert::keyExists($this->cloneRank, $gameResult['team_id'], "There is not {$gameResult['team_id']} team in rank shadow copy.");

        $this->cloneRank[$gameResult['team_id']]['win'] += $gameResult['win'];
        $this->cloneRank[$gameResult['team_id']]['loss'] += $gameResult['loss'];
        $this->cloneRank[$gameResult['team_id']]['draw'] += $gameResult['draw'];
        $this->cloneRank[$gameResult['team_id']]['points'] += $gameResult['points'];
        $this->cloneRank[$gameResult['team_id']]['goal_diff'] += $gameResult['goal_diff'];
        $this->cloneRank[$gameResult['team_id']]['game_played'] += $gameResult['game_played'];
    }

    public function getWinner()
    {
        $clone = $this->cloneRank;

        usort($clone, function($a, $b) {
            return [$b['points'], $b['goal_diff'], $b['win']] <=> [$a['points'], $a['goal_diff'], $a['win']];
        });

        return $clone[0];
    }
}
