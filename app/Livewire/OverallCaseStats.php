<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Uneca\Chimera\Livewire\CaseStats;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;

class OverallCaseStats extends CaseStats
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
            ->where(['CONS_WITH_HH = 1'])
            ->from(['cons_infra_rec'])
            ->get()->first();
        $info = [                     
            'Concession avec les ménages non collectés'=>'NA',
            'Concession avec les ménages partiellement collectés' => 'NA',
            'Concession avec les ménages totalement collectés'=>'NA'
        ];
        if (!is_null($l)) {
            $info['Concession avec les ménages partiellement collectés'] = $l->partielle??0;
            $info['Concession avec les ménages totalement collectés'] = $l->complet??0;
            $info['Concession avec les ménages non collectés'] = $l->non_collectee??0;

        }
        return collect($info);

    }
}
