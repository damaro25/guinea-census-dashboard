<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class DifferenceInResidentvsVisitor extends Chart
{
        
    public bool $useDynamicAreaXAxisTitles = true;
    public function getData(string $filterPath): Collection
    {
        try{
            $data =  (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
                        ->select(["SUM(IFNULL(rp_total, 0) + IFNULL(ra_total, 0)) as population_droit","SUM(IFNULL(rp_total, 0)-IFNULL(v_homme,0)+IFNULL(v_femme,0))  as population_fait"])
                        ->from(['sect01','sect07'])
                        ->where(['IS_DELETED in (1,3)','I19=1'])
                        ->groupBy(['area_code'])
                        ->lastlyAreaLeftJoinData()
                        ->get();
            $data->map(function ($area) {
                $area->population_droit = $area->population_droit ?? 0;
                $area->population_fait = $area->population_fait ?? 0;
                $area->difference = $area->population_droit - $area->population_fait;
                $area->txt = 'Population droit: <b>'.$area->population_droit.'</b><br>Population fait: <b>'.$area->population_fait.'</b><br>Difference: <b>'.$area->difference.'</b>';
                return $area;
            });
            return $data;
            } 
            catch (\Exception $exception) {
                return collect();
            }
        }
}
