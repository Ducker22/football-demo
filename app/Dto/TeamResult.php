<?php

namespace App\Dto;

class TeamResult
{
    private $teamId;
    private $scored;
    private $missed;

    public function __construct(int $teamId, int $scored, int $missed)
    {
        $this->teamId = $teamId;
        $this->scored = $scored;
        $this->missed = $missed;
    }

    public function fullStatTransform(): array
    {
        return [
            'teamId' => $this->teamId,
            'gamePlayed' => 1,
            'win' => $this->isWin(),
            'loss' => $this->isLoss(),
            'draw' => $this->isDraw(),
            'points' => $this->calcPoints(),
            'goalDiff' => $this->calcGoalDiff(),
        ];
    }

    public function getTeamId(): int
    {
        return $this->teamId;
    }

    private function isWin(): int
    {
        return $this->scored > $this->missed;
    }

    private function isLoss(): int
    {
        return $this->scored < $this->missed;
    }

    private function isDraw(): int
    {
        return $this->scored === $this->missed;
    }

    private function calcPoints(): int
    {
        if ($this->isWin()) {
            return 3;
        }

        if ($this->isDraw()) {
            return 1;
        }

        return 0;
    }

    private function calcGoalDiff(): int
    {
        return $this->scored - $this->missed;
    }
}
