<?php

namespace App\Livewire\MenageOrdinaire;

use Carbon\Carbon;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use Uneca\Chimera\Services\AreaTree;
use App\Services\BreakoutQueryBuilder;

class HouseholdEnumeratedByDayCumulative extends Chart
{
    public function getData(string $filterPath = ''): Collection
    {
        $data = (new BreakoutQueryBuilder(dataSource: $this->indicator->data_source, filterPath: $filterPath))
            ->select(["DATE_FORMAT(FROM_UNIXTIME(i15), '%Y-%m-%d')
                AS enumeration_date", 'COUNT(*) AS total_hh'])
            ->from(['sect01'])
            ->where(['IS_DELETED in (1,3)', 'I19=1'])
            ->groupBy(['enumeration_date'])
            ->orderBy(['enumeration_date'])
            ->get();
        $totalTarget = (new AreaTree())->areas($filterPath, referenceValueToInclude: 'households')->sum('ref_value');
        $start_date = $this->indicator->getDataSource()->start_date->subDays(1);
        $end_date = $this->indicator->getDataSource()->end_date;
        $total_enum_days = $start_date->diffInDays($end_date, false);
        $dailyTarget = safeDivide($totalTarget, $total_enum_days);

        $runningTotal = 0;
        $runningDailyTarget = 0;
        $dataKeyed = $data->keyBy('enumeration_date');
        $targets = collect(
            [
                [
                    'enumeration_date' => $start_date->format('Y-m-d'),
                    'total_hh' => 0,
                    'dailytarget' => 0,
                    'dailyPerformance' => 0,
                    'runningTotal' => 0,
                    'runningDailytarget' => 0
                ]
            ]
        );

        for ($i = 1; $i <= $total_enum_days; $i++) {
            $enumeration_date = Carbon::parse($start_date)->addDays($i)->format('Y-m-d');
            $row = [
                'enumeration_date' => $enumeration_date,
                'total_hh' => 0,
                'dailytarget' => $dailyTarget,
                'dailyPerformance' => 0,
                'runningDailytarget' => 0,
                'runningTotal' => 0
            ];
            $targets->push($row);
        }
        $targetsKeyed =  $targets->keyBy('enumeration_date');
        $allDates = $targetsKeyed->keys()->merge($dataKeyed->keys())->unique()->sort();
        $merged = $allDates->map(function ($date) use ($targetsKeyed, $dataKeyed, &$runningTotal,&$runningDailyTarget) {

            if ($frameItem = $targetsKeyed->get($date)) {
                $row = $frameItem;
            }
            else{
                $row = [
                    'enumeration_date' => $date,
                    'total_hh' => 0,
                    'dailytarget' => 0,
                    'dailyPerformance' => 0,
                    'runningDailytarget' => 0,
                    'runningTotal' => 0
                ];
            }
            if ($dataItem = $dataKeyed->get($date)) {
                $row['total_hh'] = $dataItem->total_hh;
            }
            $runningTotal += $row['total_hh'];
            $row['runningTotal'] = Number::format($runningTotal ?? 0, 0);
            $runningDailyTarget += $row['dailytarget'];
            $row['runningDailytarget'] = Number::format($runningDailyTarget ?? 0, 0);
            return (object)$row;
        });

        return $merged->values();
    }
}
