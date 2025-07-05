<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class AverageHouseholdSizeByArea extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;
    public function getData(string $filterPath): Collection
    {
        $data =  (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select(["COUNT(*) AS total_pp, count(distinct sect01.`sect01-id`) total_hh"])
            ->from(['sect01','sect02'])
            ->where(["IS_DELETED in (1,3)","I19=1"])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData(
                    referenceValueToInclude: 'household_size',
            )
            ->get();

                $aggregatedpp = $data->sum('total_pp');
                $aggregatedhh = $data->sum('total_hh');
                $aggregatedRefValue = 7.1;
                $data[] = (object)[
                    'area_code'=> '0',
                    'area_name'=>__('All ').$this->getAreaBasedAxisTitle($filterPath),
                    'area_path' => '0',
                    'total_pp' => $aggregatedpp,
                    'total_hh' => $aggregatedhh,
                    'ref_value' => $aggregatedRefValue,
                ];
        $data = $data->map(function ($dt)  {
            $dt->value = number_format( $dt->total_hh? $dt->total_pp / $dt->total_hh : 0, 1);
            $dt->txt = 'Total households: <b>'.$dt->total_hh."</b><br>Total population: <b>".$dt->total_pp.'</b><br>Average household size: <b>'.number_format($dt->value, 1).'</b>';
            return $dt;
        });

        return $data;
    }
}
