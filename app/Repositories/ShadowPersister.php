<?php

namespace App\Repositories;

use App\Contracts\PersistContract;
use App\Models\Result;
use App\Services\ShadowRank;
use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

class ShadowPersister implements PersistContract
{
    /** @var ShadowRank */
    private $shadowRank;

    public function saveMatchResult(Result $result, array $values)
    {
        // do nothing
    }

    public function getMatchResult(Collection $weeks): Collection
    {
        return collect();
    }

    public function saveRank(array $values)
    {
//        Assert::notEmpty($this->shadowRank, 'Shadow rank must be set first.');

        $this->shadowRank->addGameResult($values);
    }

    public function setShadowRank(ShadowRank $shadowRank): self
    {
        $this->shadowRank = $shadowRank;

        return $this;
    }
}
