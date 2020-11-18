<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Models\Result;
use App\Services\MatchResult;
use App\Services\SeasonDrawService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResultController extends Controller
{
    private $drawService;
    private $matchResult;

    public function __construct(SeasonDrawService $drawService, MatchResult $matchResult)
    {
        $this->drawService = $drawService;
        $this->matchResult = $matchResult;
    }

    public function index()
    {
        return Result::query()->get()->groupBy('week');
    }

    public function draw()
    {
        $this->drawService->drawSeason();

        return response()->json(['message' => 'New season has been created.'], Response::HTTP_CREATED);
    }

    public function calcMatch(ResultRequest $request)
    {
        $this->matchResult->setTeams($request->get('homeTeam'), $request->get('awayTeam'));

        return response($this->matchResult->calcResult(), Response::HTTP_CREATED);
    }
}
