<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Uneca\Chimera\Livewire\CaseStats;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;

class ListingCaseStats extends CaseStats
{
    public function getData(string $filterPath): \Illuminate\Support\Collection
    {
				
        ini_set('max_execution_time', 1800);

        $l = (new BreakoutQueryBuilder($this->dataSource->name, $filterPath, excludePartials: false,))
            ->select([
                "SUM(case when cons_is_deleted <> 3 or cons_is_deleted is null then  1 else 0 end) as carto",  
                "SUM(case when cons_is_deleted = 3 then 1 else 0 end) as nouvelle",
                "SUM(case when cons_is_deleted <> 2 or cons_is_deleted is null then 1 else 0 end) as existant",
                "SUM(case when cons_is_deleted in (1,2,3) then 1 else 0 end) as concretisee",
                "SUM(case when cons_is_deleted in (2) then  1 else 0 end) as non_existant",
                "SUM(case when cons_collect_status = 2 and cons_is_deleted in (1,3) then 1 else 0 end) as partielle",
                "SUM(case when cons_collect_status = 3  and cons_is_deleted in (1,3) then 1 else 0 end) as complet",
                "SUM(case when cons_is_deleted in (1,3) and (cons_collect_status is null or cons_collect_status not in (2,3,4)) then  1 else 0 end) as non_collectee",
                "COUNT(*) - COUNT(DISTINCT `key`) AS duplicate"
            ])
            ->from(['cons_infra_rec'])
            ->get()->first();
        $info = [
            'Totale concession carto' => 'NA',
            'Totale nouvelle concession' => 'NA',
            'Total concession concretisée' => 'NA',
            'Total concession non existante' => 'NA', 
            'Total concession existante' => 'NA',              
            'Doublons'=>'NA'];

        if (!is_null($l)) {
            $info['Totale concession carto'] = $l->carto??0;
            $info['Totale nouvelle concession'] = $l->nouvelle??0;
            $info['Total concession concretisée'] = $l->concretisee??0;
            $info['Total concession non existante'] = $l->non_existant??0;
            $info['Total concession existante'] = $l->existant??0;
            $info['Doublons'] = $l->duplicate??0;

        }
        return collect($info);

    }
}
