<?php

namespace App\Livewire\MenageOrdinaire;

use App\Services\Lookups;
use Carbon\Carbon;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class HouseholdsEnumeratedAgainstTargetByArea extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;
    use Lookups;
    public function getData(string $filterPath): Collection
    {
        try {
            $data =  (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
                ->select(["COUNT(*) AS total"])
                ->from(['sect01'])
                ->where(['IS_DELETED in (1,3)','I19=1'])
                ->groupBy(['area_code'])
                ->lastlyAreaLeftJoinData(referenceValueToInclude: 'households')
                ->get();

            $now = Carbon::now();
            $startDate = $this->indicator->getDataSource()->start_date->subDays(1);
            $endDate = $this->indicator->getDataSource()->end_date;

            $total_Enum_days=$startDate->diffInDays($endDate,false);
            $days_Since_enum_start=$startDate->diffInDays($now,false);
            $day_count_yesterday=$startDate->diffInDays($now,false) - 1;

            if($days_Since_enum_start > $total_Enum_days) {
                $days_Since_enum_start = $total_Enum_days;
            }
            if($day_count_yesterday > $total_Enum_days) {
                $day_count_yesterday = $total_Enum_days;
            }
            $data = $data->map(function ($area) use ($day_count_yesterday, $days_Since_enum_start, $total_Enum_days) {
                $area->expected = $area->ref_value;
                $area->total = $area->total ?? 0;
                $area->proportion = Number::format(safeDivide($area->total, $area->ref_value) * 100, 0);
                $area->expected = Number::format(safeDivide($days_Since_enum_start, $total_Enum_days) * 100, 0);
                $area->expected_yesterday = Number::format(safeDivide($day_count_yesterday, $total_Enum_days) * 100, 0);
                $area->expected_no = Number::format(safeDivide($days_Since_enum_start, $total_Enum_days) * $area->ref_value,0);
                $area->expected_no_yesterday = Number::format(safeDivide($day_count_yesterday, $total_Enum_days) * $area->ref_value,0);
                $area->txt = 'Total target: <b>'.$area->ref_value."</b><br>Today's target: <b>".$area->expected_no
                    ."</b><br>Yesterday's target: <b>".$area->expected_no_yesterday.'</b><br>Enumerated HHs: <b>'.$area->total.'</b>';

                return $area;
            });

            return $data;
        } catch (\Exception $exception) {
            return collect();
        }
    }
}
