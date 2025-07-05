<?php

namespace App\Livewire\Scorecard\MenageOrdinaire;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;

class AverageHouseholdSize extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {
        $l = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["count(*)/count(distinct sect01.`sect01-id`) AS value"])
            ->from(['sect01','sect02'])
            ->where(['IS_DELETED in (1,3)','I19=1'])
            ->get()
            ->first();
        return collect([$this->getNumberFormatter(1)->format($l->value??0, 1), null]);
    }
}
