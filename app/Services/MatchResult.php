<?php

namespace App\Services;

use App\Contracts\ResultGenerator;
use App\Dto\TeamResult;
use App\Models\Rank;
use App\Models\Result;
use App\Services\ResultGens\PlainGen;
use Illuminate\Support\Collection;
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

    /**
     * @param int|array $weeks
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function calcForWeeks($weeks): \Illuminate\Database\Eloquent\Collection
    {
        $weeks = collect($weeks);

        foreach ($weeks as $week) {

            $matches = Result::query()->where('week', $week)->get();

            $matches->each(function(Result $result) {

                $this->calcSingleMatch($result);
            });
        }

        return Result::query()->whereIn('week', $weeks)->get();
    }

    public function calcResult()
    {
        Assert::notEmpty($this->teamHome,'Home team must be set.');
        Assert::notEmpty($this->teamAway,'Away team must be set.');

        $calc = $this->generator->generate();

        $teamHomeScored = $calc['homeScored'];
        $teamAwayScored = $calc['awayScored'];

        $result[] = (new TeamResult($this->teamHome, $teamHomeScored, $teamAwayScored))->fullStatTransform();
        $result[] = (new TeamResult($this->teamAway, $teamAwayScored, $teamHomeScored))->fullStatTransform();

        //todo: to the repository
        foreach ($result as $teamPlayed) {
            $ladderRaw = Rank::query()->where('team_id', $teamPlayed['teamId'])->first();

            $ladderRaw->game_played = $ladderRaw->game_played + $teamPlayed['gamePlayed'];
            $ladderRaw->win = $ladderRaw->win + $teamPlayed['win'];
            $ladderRaw->loss = $ladderRaw->loss + $teamPlayed['loss'];
            $ladderRaw->draw = $ladderRaw->draw + $teamPlayed['draw'];
            $ladderRaw->points = $ladderRaw->points + $teamPlayed['points'];
            $ladderRaw->goal_diff = $ladderRaw->goal_diff + $teamPlayed['goalDiff'];

            $ladderRaw->save();
        }

        return [
            'homeScored' => $teamHomeScored,
            'awayScored' => $teamAwayScored,
        ];
    }

    public function setTeams(int $teamHome, int $teamAway): self
    {
        Assert::notEq($teamHome, $teamAway, 'Teams must not be equal.');

        $this->teamHome = $teamHome;
        $this->teamAway = $teamAway;

        return $this;
    }

    private function calcSingleMatch(Result $result)
    {
        $this->setTeams($result->home_team_id, $result->away_team_id);

        $tmp = $this->calcResult();
        $result->home_team_scored = $tmp['homeScored'];
        $result->away_team_scored = $tmp['awayScored'];
        $result->save();

        return $result;
    }
}
