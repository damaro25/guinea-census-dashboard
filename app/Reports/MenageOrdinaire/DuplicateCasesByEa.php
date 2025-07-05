<?php

namespace App\Reports\MenageOrdinaire;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;

class DuplicateCasesByEa extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {   list(, $whereConditions) = QueryFragmentFactory::make($this->report->data_source)->getSqlFragments($filterPath);

        $sql= (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath))
               ->select(array_merge(
            ["CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path",
                "men_id AS `household number`",
                "`key`", "case when partial_save_mode is null then 'complete' else 'partial' end as `case status`",
                "COUNT(`key`) AS duplicates",
                "'' AS interviewers"

            ]
        ))
        ->from(['sect01'])
        ->where($whereConditions)
        ->groupBy(["path, men_id, `key`,partial_save_mode"])
        ->having(['`duplicates` > 1'])
        ->toSql();
        $sql= "SELECT EA.REGION,EA.PREFECTURE AS `PRÉFECTURE`,EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`,EA.`ZS`,EA.`ZC`,D.`household number`,`key`,`case status`,duplicates,interviewers AS `Code Agent` FROM
( ". $sql . ") D
	INNER JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) ORDER BY path";

    return (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath))
    ->get($sql);
    }
}
