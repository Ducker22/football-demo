<?php

namespace App\Services;

use App\Contracts\PersistContract;
use App\Contracts\ResultGenerator;
use App\Dto\TeamResult;
use App\Models\Result;
use App\Repositories\DbPersist;
use App\Services\ResultGens\PlainGen;
use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

class MatchResult
{
    private $teamHome;
    private $teamAway;

    private $generator;
    private $persister;

    public function __construct(ResultGenerator $generator = null, PersistContract $persister = null)
    {
        $this->generator = $generator ?? new PlainGen();
        $this->persister = $persister ?? new DbPersist();
    }

    public function setPersister(PersistContract $persister): self
    {
        $this->persister = $persister;

        return $this;
    }

    /**
     * @param int|array $weeks
     * @return Collection
     */
    public function calcForWeeks($weeks): Collection
    {
        $weeks = collect($weeks);

        foreach ($weeks as $week) {

            $matches = Result::query()->where('week', $week)->get();

            $matches->each(function(Result $result) {

                $this->calcSingleMatch($result);
            });
        }

        return $this->persister->getMatchResult($weeks);
    }

    public function editMatch($result, $newResult)
    {
        $revertResult[] = (new TeamResult($result->home_team_id, $result->home_team_scored, $result->away_team_scored))->fullStatTransform();
        $revertResult[] = (new TeamResult($result->away_team_id, $result->away_team_scored, $result->home_team_scored))->fullStatTransform();

        $flushResult[] = (new TeamResult($result->home_team_id, $newResult['homeScored'], $newResult['awayScored']))->fullStatTransform();
        $flushResult[] = (new TeamResult($result->away_team_id, $newResult['awayScored'], $newResult['homeScored']))->fullStatTransform();

        foreach ($revertResult as $teamPlayed) {
            $this->persister->saveRank($teamPlayed, true);
        }

        foreach ($flushResult as $teamPlayed) {
            $this->persister->saveRank($teamPlayed);
        }

        $this->persister->saveMatchResult($result, [
            'homeScored' => $newResult['homeScored'],
            'awayScored' => $newResult['awayScored'],
        ]);

        return $result;
    }

    private function calcResult()
    {
        Assert::notEmpty($this->teamHome,'Home team must be set.');
        Assert::notEmpty($this->teamAway,'Away team must be set.');

        $calc = $this->generator->generate();

        $teamHomeScored = $calc['homeScored'];
        $teamAwayScored = $calc['awayScored'];

        $result[] = (new TeamResult($this->teamHome, $teamHomeScored, $teamAwayScored))->fullStatTransform();
        $result[] = (new TeamResult($this->teamAway, $teamAwayScored, $teamHomeScored))->fullStatTransform();

        foreach ($result as $teamPlayed) {
            $this->persister->saveRank($teamPlayed);
        }

        return [
            'homeScored' => $teamHomeScored,
            'awayScored' => $teamAwayScored,
        ];
    }

    private function setTeams(int $teamHome, int $teamAway): self
    {
        Assert::notEq($teamHome, $teamAway, 'Teams must not be equal.');

        $this->teamHome = $teamHome;
        $this->teamAway = $teamAway;

        return $this;
    }

    private function calcSingleMatch(Result $result)
    {
        $this->setTeams($result->home_team_id, $result->away_team_id);

        $this->persister->saveMatchResult($result, $this->calcResult());

        return $result;
    }
}
