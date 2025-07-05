<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class PartiallyCompletedCases extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;

    public function getData(string $filterPath): Collection
    {
        return (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select([
                'SUM(CASE WHEN I19 =1 THEN 0 ELSE 1 END) AS total'])
            ->from(['sect01',])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData()
            ->get();
    }
}
