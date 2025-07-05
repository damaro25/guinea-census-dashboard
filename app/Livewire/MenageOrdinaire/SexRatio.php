<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class SexRatio extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;

    public function getData(string $filterPath): Collection
    {
        $data = (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select([
                'COUNT(*) AS total',
                'SUM(CASE WHEN P03 = 1 THEN 1 ELSE 0 END) AS males',
                'SUM(CASE WHEN P03 = 2 THEN 1 ELSE 0 END) AS females'
            ])
            ->from(['sect01', 'sect02',])
            ->where(['IS_DELETED in (1,3)', 'I19=1', 'p11=1'])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData(
                referenceValueToInclude: 'sex_ratio',
            )
            ->get()
            ->map(function ($item) {
                $item->ratio = safeDivide($item->males, $item->females) * 100;
                $item->reference_100 = 100;
                return $item;
            });
        // Add national row (aggregate)
        $data = $data->all();
        if (count($data) > 0) {
            $total_males = array_sum(array_column($data, 'males'));
            $total_females = array_sum(array_column($data, 'females'));
            $national_ratio = safeDivide($total_males, $total_females) * 100;
            $national = (object) [
                'area_code' => '0',
                'area_name' => __('National'),
                'males' => $total_males,
                'females' => $total_females,
                'ratio' => $national_ratio,
                'reference_100' => 100
            ];
            $data[] = $national;
        }
        return collect($data);
    }
}
