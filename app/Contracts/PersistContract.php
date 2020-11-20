<?php

namespace App\Contracts;

use App\Models\Result;
use Illuminate\Support\Collection;

interface PersistContract
{
    public function saveMatchResult(Result $result, array $values);

    public function getMatchResult(Collection $weeks);

    public function saveRank(array $values);
}
