<?php

namespace App\Livewire\Scorecard\Concession;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\AreaTree;


class AverageHouseholdSize extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {

        $l = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["SUM(CONS_TOT_PERS_CARTO)/SUM(CONS_MEN_ORD_CARTO) AS value"])
            ->from(['cons_infra_rec'])
            ->where(['CONS_IS_DELETED in (1,3)','CONS_TOT_PERS_CARTO > 0','CONS_MEN_ORD_CARTO > 0'])
            ->get()
            ->first();
        $totalHH = (new AreaTree())->areas($filterPath, referenceValueToInclude: 'households')->sum('ref_value');
        $totalPopulation = (new AreaTree())->areas($filterPath, referenceValueToInclude: 'population')->sum('ref_value');

        $totalTarget = $totalPopulation / $totalHH;
        $performance = abs($l->value - $totalTarget);
        if ($performance >= 0.1) {
            $status = "#DC2626"; // Red if difference is more than 1
        } else {
            $status = "#16A34A"; // Green otherwise
        }

        return collect([$this->getNumberFormatter(1)->format($l->value??0),null,$status]);    
    }
}
