<?php

namespace App\Services;

use App\Contracts\ResultGenerator;
use App\Dto\TeamResult;
use App\Services\ResultGens\PlainGen;
use Webmozart\Assert\Assert;

class MatchResult
{
    private $generator;
    private $teamHome;
    private $teamAway;

    public function __construct(ResultGenerator $generator = null)
    {
        $this->generator = $generator ?? new PlainGen();
    }

    public function calcResult()
    {
        Assert::isEmpty($this->teamHome,'Home team must be set.');
        Assert::isEmpty($this->teamAway,'Away team must be set.');

        $calc = $this->generator->generate();

        $teamHomeScored = $calc['homeScored'];
        $teamAwayScored = $calc['awayScored'];

        $result[] = (new TeamResult($this->teamHome, $teamHomeScored, $teamAwayScored))->fullStatTransform();
        $result[] = (new TeamResult($this->teamAway, $teamAwayScored, $teamHomeScored))->fullStatTransform();

        return $result;
    }

    public function setTeams(int $teamHome, int $teamAway): self
    {
        Assert::notEq($teamHome, $teamAway, 'Teams must not be equal.');

        $this->teamHome = $teamHome;
        $this->teamAway = $teamAway;

        return $this;
    }
}
