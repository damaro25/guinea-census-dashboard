<?php

namespace App\Livewire\Scorecard\Concession;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;

class TotalPopulationInstitution extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {
        $l = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["SUM(CONS_TOT_PERS_COL_CENSUS) AS value"])
            ->from(['cons_infra_rec'])
            ->where(['CONS_IS_DELETED in (1,3)'])
            ->get()
            ->first();
        return collect([$this->getNumberFormatter(0)->format($l->value??0),null,null]);   
     }
}
