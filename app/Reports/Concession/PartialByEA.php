<?php

namespace App\Reports\Concession;

use App\Reports\GuineaReport;
use App\Services\AreaTreeExt;
use Uneca\Chimera\Models\AreaHierarchy;
use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use Uneca\Chimera\Services\AreaTree;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;

class PartialByEA extends GuineaReport
{
    public function getData(string $filterPath): Collection
    {
        $areas = (new AreaTreeExt())->leaf($filterPath,includeAncestors: true)->keyBy('code');
        $areaHierarchy = AreaHierarchy::orderBy('index')->pluck('name')->all();
        $data =  (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
            ->select(array_merge([
                "SUM(CASE WHEN partial_save_mode is NULL THEN 1 ELSE 0 END) AS partial",
                'cons_zs_id as zs',
                'cons_zc_id as zc',
                'cons_zd_id as zd'],[]))
            ->from(['cons_infra_rec'])
            ->groupBy(['zd'])
            ->having([ "partial > 0"])
            ->orderBy(["zd"])
            ->get();

        $data = $data->map(function ($item) use ($areas,$areaHierarchy) {
            $d =(array) $item;
            if(array_key_exists($item->zd,$areas->toArray()) ){
                $area = $areas[$item->zd];
                $ancestors = json_decode($area['ancestor_names'], true);
                foreach($areaHierarchy as $key=>$value) {
                    if(!isset($ancestors[$key])) {
                        $d[$value] = null;
                    } else {
                        $ancestor = $ancestors[$key];
                        $d[$value] = $ancestor[app()->getLocale()]??$ancestor[app()->getFallbackLocale()];
                    }

                }
            }
            return (object) $d;
        });

        return $data;
    }
}
