<?php

namespace App\Reports\MenageOrdinaire;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use Uneca\Chimera\Services\QueryFragmentFactory;
use App\Services\BreakoutQueryBuilder;

class LastSyncNotRecent extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {
         list(, $whereConditions) = QueryFragmentFactory::make($this->report->data_source)->getSqlFragments($filterPath);

        $whereClause = "";
        if (count($whereConditions) > 0) {
            $whereClause = "AND " . implode(' AND ', $whereConditions);
        }

        $sql= " SELECT full_path AS `EA code`, EA.REGION,PREFECTURE AS PRÉFECTURE,EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`,EA.`ZS`,EA.`ZC`,D.Enumerated_hh,hours_since_last_synced,last_synced_time FROM
                (SELECT CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path,
                COUNT(*) AS Enumerated_hh,
                TIMESTAMPDIFF(HOUR, MAX(cspro_jobs.modified_time), SYSDATE() ) as `hours_since_last_synced`,
                MAX(cspro_jobs.modified_time) AS `last_synced_time`
                FROM `level-1`
                INNER JOIN sect01 ON sect01.`level-1-id`=`level-1`.`level-1-id`
                LEFT JOIN cspro_jobs ON last_modified_revision >= cspro_jobs.start_revision AND
                    last_modified_revision <= cspro_jobs.end_revision
                WHERE `key` != '' AND deleted = 0 AND IS_DELETED in (1,3)  $whereClause
                GROUP BY `path` ) D
                RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.`path` USING utf8mb4)
                ORDER BY `path`";


        return (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
        ->get($sql);
    }
}
