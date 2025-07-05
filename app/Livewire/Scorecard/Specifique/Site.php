<?php

namespace App\Livewire\Scorecard\Specifique;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;

class Site extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {

        $l = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["COUNT(*) AS value"])
            ->from(['sect01'])
            ->where(['I19=1'])
            ->get()
            ->first();
        return collect([$this->getNumberFormatter(0)->format($l->value??0), null]);
    }
}
