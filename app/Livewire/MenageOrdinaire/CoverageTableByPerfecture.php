<?php

namespace App\Livewire\MenageOrdinaire;

use Carbon\Carbon;
use Illuminate\Support\Number;
use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use App\Services\AreaTreeExt;

class CoverageTableByPerfecture extends Chart
{

    public function getData(string $filterPath = ''): Collection
    {

        [$selectColumns, $whereConditions, $fromTables] = (new \App\Services\QueryFragments\ListingQueryFragments())->getSqlFragments($filterPath);
        $areas = (new AreaTreeExt())->getAreasByLevel(1)->keyBy('code');
        $data =  (new BreakoutQueryBuilder('listing'))
            ->select(["LPAD(SUBSTRING(cons_zd_id, 1, 2), 2, '0') area_code_prefecture",
                      "SUM(case when cons_is_deleted <> 3 or cons_is_deleted is null then  1 else 0 end) as carto", 
                      "SUM(case when cons_is_deleted <> 2 or cons_is_deleted is null then 1 else 0 end) as existant",
                      "SUM(case when cons_collect_status = 3  and cons_is_deleted in (1,3) then 1 else 0 end) as complet",
                      ])
            ->from(['cons_infra_rec'])
            ->groupBy(['area_code','area_code_prefecture'])
            ->get();
        $data = $data->map(function ($area) use ($areas) {
            $area->area_name = $areas[$area->area_code_prefecture]->name ?? $area->area_code_prefecture;
            $area->couverture_carto = Number::format(safeDivide($area->complet, $area->carto) * 100, 0);
            $area->couverture_existant = Number::format(safeDivide($area->complet, $area->existant) * 100, 0);
            return $area;
        });
        // Add aggregate row
        if ($data->count() > 0) {
            $agg_carto = $data->sum('carto');
            $agg_existant = $data->sum('existant');
            $agg_complet = $data->sum('complet');
            $agg_couverture_carto = $agg_carto > 0 ? Number::format(safeDivide($agg_complet, $agg_carto) * 100, 0) : 0;
            $agg_couverture_existant = $agg_existant > 0 ? Number::format(safeDivide($agg_complet, $agg_existant) * 100, 0) : 0;
            $data[] = (object) [
                'area_code' => '0',
                'area_name' => __('Guinée'),
                'carto' => $agg_carto,
                'existant' => $agg_existant,
                'complet' => $agg_complet,
                'couverture_carto' => $agg_couverture_carto,
                'couverture_existant' => $agg_couverture_existant,
            ];
        }
          $data = $data->map(function ($item) {
            $item->{'Nom de region'} = $item->area_name;
            $item->{'Couverture Carto (%)'} = $item->couverture_carto;
            $item->{'Couverture Existant (%)'} = $item->couverture_existant;
            return $item;
        });

        return $data;
    }
    public function getTraces(Collection $data, string $filterPath, bool $designMode = false): array
    {
        $data = $data->toArray();
        $headerColor = '#d3d3d3'; // grey
        $header = [
            ['Nom de region', 'Couverture par rapport au concessions Carto (%)', ' Couverture par rapport au concessions existantes (%)']
        ];
        $cells = [
            array_column($data, 'Nom de region'),
            array_column($data, 'Couverture Carto (%)'),
            array_column($data, 'Couverture Existant (%)')
        ];
        $trace = [
            'type' => 'table',
            'header' => [
                'values' => $header[0],
                'fill' => ['color' => $headerColor],
                'align' => 'left',
                'font' => ['color' => 'black', 'size' => 14]
            ],
            'cells' => [
                'values' => $cells,
                'align' => ['left','right','right'], // Align cells to the center for the first column and left for the others
                'font' => ['color' => 'black', 'size' => 12]
            ]
        ];
        return [$trace];
    }
}
