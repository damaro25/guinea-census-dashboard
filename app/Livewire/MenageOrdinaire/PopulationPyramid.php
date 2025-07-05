<?php

namespace App\Livewire\MenageOrdinaire;

use App\Services\Formatter;
use App\Services\Lookups;
use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class PopulationPyramid extends Chart
{
    use Lookups;
    use Formatter;
    public function getData(string $filterPath = ''): Collection
    {
        $result = (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select([
                "CONCAT(FLOOR(P05A/5) * 5, '-', FLOOR(P05A/5) * 5 + 4) AS age_range",
                "FLOOR(P05A/5) * 5 AS range_start",
                "SUM(CASE WHEN P03 = 1 THEN 1 ELSE 0 END) AS males",
                "SUM(CASE WHEN P03 = 2 THEN 1 ELSE 0 END) AS females",
                "-1 * SUM(CASE WHEN P03 = 1 THEN 1 ELSE 0 END) AS males_negated"
            ])
            ->from(['sect01', 'sect02'])
            ->where(['IS_DELETED in (1,3)', 'I19=1', 'p11=1'])
            ->groupBy(['range_start'])
            ->orderBy(['range_start'])
            ->get();

        $totalMales = $result->sum('males');
        $totalFemales = $result->sum('females');

        return $result->map(function ($item) use ($totalMales,$totalFemales) {
                return [
                    'age_range' => $item->age_range,
                    'range_start' => $item->range_start,
//                    'males' => safeDivide($item->males,($totalMales+$totalFemales)) * 100,
//                    'females' => safeDivide($item->females,($totalMales+$totalFemales)) * 100
                    'males' =>  round( safeDivide($item->males,($totalMales+$totalFemales))*100,1),
                    'females'=> round(safeDivide($item->females,($totalMales+$totalFemales))*100,1),
                    'males_txt' =>  $item->males,
                    'females_txt'=> $item->females,

                ];
        });
    }
}
