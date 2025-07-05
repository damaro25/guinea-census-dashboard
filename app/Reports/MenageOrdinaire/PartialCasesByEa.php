<?php

namespace App\Reports\MenageOrdinaire;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class PartialCasesByEa extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {
        return (new BreakoutQueryBuilder($this->report->data_source, filterPath: $filterPath, excludePartials:false))
                ->select(array_merge(
            [
            "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id) AS path",
            "cons_zd_id as EA",
            "'' AS interviewer",
            "SUM(CASE WHEN I19=2 THEN 1 ELSE 0 END) AS 'No. of partial cases'"]
        ))
        ->from(['sect01'])
        ->where(['IS_DELETED in (1,3)'])
        ->groupBy(["cons_zd_id"])
        ->having(['`No. of partial cases` > 0'])
        ->orderBy(["cons_zd_id"])
        ->get();
    }
}
