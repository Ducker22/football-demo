<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RankResource;
use App\Services\RankService;
use Illuminate\Http\Request;

class RankController extends Controller
{
    private $rankService;

    public function __construct(RankService $rankService)
    {
        $this->rankService = $rankService;
    }

    public function index()
    {
        return response(RankResource::collection($this->rankService->getRanks()));
    }
}
