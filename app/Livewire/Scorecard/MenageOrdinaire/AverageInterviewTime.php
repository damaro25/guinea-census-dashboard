<?php

namespace App\Livewire\Scorecard\MenageOrdinaire;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;

class AverageInterviewTime extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {
        $result = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select(["AVG(DUREE_INTERVIEW_MINUTES/60) AS minutes"])
            ->from(['sect01'])
            ->where(['IS_DELETED in (1,3)','I19=1','DUREE_INTERVIEW_MINUTES is not null'])
            ->get()
            ->first();
        return collect([$this->getNumberFormatter(0)->format($result->minutes ?? 0, 1), null]);

    }
}
