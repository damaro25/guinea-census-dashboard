<?php

namespace App\Livewire\Scorecard\MenageCollectif;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;

class TotalPopulation extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {
        $l = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["COUNT(*) AS value"])
            ->from(['sect01','sect03'])
            ->where(['COL_IS_DELETED in (1,3)'])
            ->get()
            ->first();
        return collect([$this->getNumberFormatter(0)->format($l->value??0), null]);
    }
}
