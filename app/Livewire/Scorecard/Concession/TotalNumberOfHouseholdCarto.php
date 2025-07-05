<?php

namespace App\Livewire\Scorecard\Concession;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use Uneca\Chimera\Services\AreaTree;
use App\Services\BreakoutQueryBuilder;

class TotalNumberOfHouseholdCarto extends ExtScorecardComponent
{

    public function getData(string $filterPath): Collection
    {
        $l = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["SUM(CONS_MEN_ORD_CENSUS) AS value"])
            ->from(['cons_infra_rec'])
            ->where(['CONS_IS_DELETED in (1,3)'])
            ->get()
            ->first();
        $totalTarget = (new AreaTree())->areas($filterPath, referenceValueToInclude: 'households')->sum('ref_value');
        $performance = $this->getNumberFormatter(0)->format(safeDivide($l->value??0, $totalTarget)*100??0);
        if ($performance <= 80) {
            $status = "#DC2626";#
        } elseif ($performance < 95 && $performance > 80) {
            $status = "#F59E0B";
        } elseif ($performance >= 95) {
            $status = "#16A34A";
        }
        else {
            $status = "#ccc";
        }

        return collect([$this->getNumberFormatter(0)->format($l->value??0),$performance,$status]);
    }
}
