<?php

namespace App\Reports\MenageOrdinaire;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class WronglyDatedCases extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {
        $questionnaire = $this->report->getDataSource();
        $startDate = $questionnaire->start_date->subDays(1)->timestamp;

        $sql = (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath))
        ->select([
            "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path",
            "zd_id as EA",
            "'' AS interviewer",
            "COUNT(*) AS 'No. of cases'"
            ])
        ->from(['sect01'])
        ->where(array_merge(["DATE_FORMAT(FROM_UNIXTIME(i16), '%Y-%m-%d') < ". $startDate ]))
        ->groupBy(["path"])
        ->having(['`No. of cases` > 0'])
        ->toSql();

        $sql = "SELECT EA.REGION, EA.PREFECTURE AS `PRÉFECTURE`, EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`, EA.`ZS`, EA.`ZC`,D.interviewer, D.`No. of cases` FROM
                ( " . $sql . ") D
                RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'";
        $data = (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
            ->get($sql);

        return $data;
    }
}



