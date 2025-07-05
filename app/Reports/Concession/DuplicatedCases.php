<?php

namespace App\Reports\Concession;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;
use Uneca\Chimera\AreaTree;

class DuplicatedCases extends ReportBaseClass
{

    public function getData(string $filterPath): Collection
    {

        $sql= (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath))
               ->select(array_merge(
            ['CONCAT(SUBSTRING(cons_zd_id, 1, 1),".",LPAD(SUBSTRING(cons_zd_id, 1, 2), 2, \'0\'),".",SUBSTRING(cons_zd_id, 1, 4),".",cons_zs_id,".",cons_zc_id,".",cons_zd_id) AS path',
                "cons_id AS `structure number`",
                "`key`", "case when partial_save_mode is null then 'complete' else 'partial' end as `case status`",
                "COUNT(`key`) AS duplicates",
                "'' AS interviewers"

            ]
        ))
        ->from(['cons_infra_rec'])
        ->where(['CONS_IS_DELETED in (1,3)'])
        ->groupBy(["path, cons_id, `key`,partial_save_mode"])
        ->having(['`duplicates` > 1'])
        ->toSql();
        $sql= "SELECT EA.REGION,EA.PREFECTURE AS PRÉFECTURE,EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`,EA.`ZS`,EA.`ZC`,D.`structure number`,`key`,`case status`,duplicates,interviewers AS `Code Agent` FROM
( ". $sql . ") D
	INNER JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) WHERE EA.full_path LIKE '$filterPath%'";

    return (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath))
    ->get($sql);

    }

}
