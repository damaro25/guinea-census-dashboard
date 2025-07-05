<?php

namespace App\Livewire\MenageCollectif;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class PopulationEnumeratedByArea extends Chart
{
    public function getData(string $filterPath): Collection
    {
        try {
            $data =  (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
                ->select(["COUNT(*) AS total"])
                ->from(['sect01','sect03'])
                ->where(['COL_IS_DELETED in (1,3)'])
                ->groupBy(['area_code'])
                ->lastlyAreaLeftJoinData()
                ->get();

            return $data;
        } catch (\Exception $exception) {
            return collect();
        }
    }
}
