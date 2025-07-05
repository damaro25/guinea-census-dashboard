<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class CrudeBirthRateByArea extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;
    public function getData(string $filterPath): Collection
    {
        $data =  (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select(['SUM(P66M + P66F) AS birth',
                'COUNT(*) AS total'])
            ->from(['sect01','sect02'])
            ->where(['IS_DELETED in (1,3)', 'I19=1', 'p11=1'])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData(
                referenceValueToInclude: 'birth_rate',
            )
            ->get();

        $data = $data->map(function ($row)  {
            $row->expected = 29.586; //Source: World Population Prospects: The 2024 Revision United Nations Population Division

            $row->rate = safeDivide($row->birth, $row->total) * 1000 ;

            return $row;
        });
        return $data;
    }
}
