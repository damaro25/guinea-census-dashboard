<?php

namespace App\Livewire\MenageOrdinaire;

use Carbon\Carbon;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use Uneca\Chimera\Services\AreaTree;
use App\Services\BreakoutQueryBuilder;

class HouseholdsEnumeratedAgainstTargetByDay extends Chart
{
    public function getData(string $filterPath = ''): Collection
    {
        $data = (new BreakoutQueryBuilder(dataSource: $this->indicator->data_source, filterPath: $filterPath))
            ->select(["DATE_FORMAT(FROM_UNIXTIME(i15), '%Y-%m-%d')
                AS enumeration_date", 'COUNT(*) AS total_hh',
                '0 AS ref_value', 'NULL AS dailytarget', 'count(*) AS dailyPerformance'])
            ->from(['sect01'])
            ->where(['IS_DELETED in (1,3)','I19=1'])
            ->groupBy(['enumeration_date'])
            ->orderBy(['enumeration_date'])
            ->get();
        $totalTarget = (new AreaTree())->areas($filterPath, referenceValueToInclude: 'households')->sum('ref_value');

        $start_date = $this->indicator->getDataSource()->start_date->subDays(1);
        $end_date = $this->indicator->getDataSource()->end_date;
        $total_enum_days=$start_date->diffInDays($end_date,false);
        $start_date = $start_date->format('Y-m-d');
        $dailyTarget = Number::format(safeDivide($totalTarget, $total_enum_days), 0);



        for($i = 1; $i <= $total_enum_days; $i++) {
            $enumeration_date = Carbon::parse($start_date)->addDays($i)->format('Y-m-d');
            if ($data->where('enumeration_date',$enumeration_date )->isEmpty()) {
                $data->push((object)[
                    'enumeration_date' => $enumeration_date,
                    'total_hh' => 0,
                    'dailytarget' => $dailyTarget,
                    'dailyPerformance' => 0
                ]);
            } else {
                $row = $data->where('enumeration_date', $enumeration_date)->first();
                $row->dailytarget = $dailyTarget;
                $row->dailyPerformance = $row->total_hh;
            }
        }



        return $data;
    }
}
