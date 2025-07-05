<?php

namespace App\Livewire\Scorecard\MenageOrdinaire;

use App\Livewire\Scorecard\ExtScorecardComponent;
use Illuminate\Support\Collection;
use Uneca\Chimera\Livewire\ScorecardComponent;
use App\Services\BreakoutQueryBuilder;

class SexRatio extends ExtScorecardComponent
{
    public function getData(string $filterPath): Collection
    {
        $item = (new BreakoutQueryBuilder($this->scorecard->data_source, $filterPath))
            ->select([
                'COUNT(*) AS total',
                'SUM(CASE WHEN P03 = 1 THEN 1 ELSE 0 END) AS males',
                'SUM(CASE WHEN P03 = 2 THEN 1 ELSE 0 END) AS females'
            ])
            ->from(['sect01', 'sect02',])
            ->get()
            ->first();
            $ratio = $item->males?safeDivide($item->males, $item->females) * 100:'NA';
            return collect([
                $this->getNumberFormatter(0)->format($ratio ?? 0),null
            ]);
    }
}
