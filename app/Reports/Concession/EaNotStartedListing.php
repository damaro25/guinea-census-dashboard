<?php

namespace App\Reports\Concession;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;

class EaNotStartedListing extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {
       list(, $whereConditions) = QueryFragmentFactory::make($this->report->data_source)->getSqlFragments($filterPath);

        $sql= (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
            ->select(['CONCAT(SUBSTRING(cons_zd_id, 1, 1),".",LPAD(SUBSTRING(cons_zd_id, 1, 2), 2, \'0\'),".",SUBSTRING(cons_zd_id, 1, 4),".",cons_zs_id,".",cons_zc_id,".",cons_zd_id) AS `path`, COUNT(*) AS listed_hh'])
            ->from(['cons_infra_rec'])
            ->where(['CONS_IS_DELETED in (1,3)'])
            ->groupBy(["`path`"])
            ->orderBy(["`path`"])
            ->toSql();

            $sql= "SELECT full_path AS `EA code`, EA.REGION,EA.PREFECTURE AS PRÉFECTURE,EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`,EA.`ZS`,EA.`ZC`,D.listed_hh FROM
            ( ". $sql . ") D
                    RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'
            ";

            $data = (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath))
            ->get($sql);

        $data = $data->map(function ($area) {

            $actual = $area->listed_hh ?? 0;

            if($actual > 0) {
                return false;
            }

            return $area;
        })->reject(function ($area) {
            return empty($area);
        });


        return $data;

    }
}
