<?php

namespace App\Livewire\MenageOrdinaire;

use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class AverageInterviewTimeByArea extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;
    public function getData(string $filterPath): Collection
    {
        $data = (new BreakoutQueryBuilder(dataSource: $this->indicator->data_source, filterPath: $filterPath))
            ->select(['Avg(DUREE_INTERVIEW_MINUTES/60) AS tot_time'])
            ->from(['sect01'])
            ->where([
                "DUREE_INTERVIEW_MINUTES > 1",
                "DUREE_INTERVIEW_MINUTES < 7200","IS_DELETED in (1,3)","I19=1"])

            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData()
            ->get();

        $data = $data->map(function ($dt)  {
            $dt->tot_time = $dt->tot_time?Number::format($dt->tot_time, 0):0;
            return $dt;
        });

        return $data;
    }
}
