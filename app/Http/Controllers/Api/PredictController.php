<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PredictService;
use Illuminate\Http\Request;

class PredictController extends Controller
{
    private $predictService;

    public function __construct(PredictService $predictService)
    {
        $this->predictService = $predictService;
    }

    public function index()
    {
        return $this->predictService->predict();
    }
}
