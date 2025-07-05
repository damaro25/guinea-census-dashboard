<?php

namespace App\Reports\MenageOrdinaire;

use App\Reports\GuineaReport;
use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class EnumeratorPerformanceWithDate extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {
        $sql = (new BreakoutQueryBuilder($this->report->data_source))
            ->select(array_merge(
                [
                    "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path",
                    "'' AS interviewer",
                    "COUNT(*) AS enum_hh",
                    "DATE_FORMAT(FROM_UNIXTIME(i16), '%Y-%m-%d') AS enumeration_date"
                ]
            ))
            ->from(['sect01'])
            ->where(['IS_DELETED in (1,3)','I19=1'])
            ->groupBy(["path,enumeration_date"])
            ->orderBy(['path,enumeration_date'])
            ->toSql();

        $sql = "SELECT full_path AS `EA code`, EA.REGION, EA.PREFECTURE AS `PRÉFECTURE`, EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`, EA.`ZS`, EA.`ZC`, D.enum_hh, D.enumeration_date,D.interviewer, path FROM
                ( " . $sql . ") D
                RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'";
        $data = (new BreakoutQueryBuilder($this->report->data_source,$filterPath))
            ->get($sql);

        // Return flat data to avoid OpenSpout error
        // First, collect all unique dates
        $allDates = $data->pluck('enumeration_date')->unique()->sort()->values();

        $pivotData = $data->groupBy('path')
            ->map(function($group) use ($allDates) {
            $firstItem = $group->first();
            $row = [
            'path' => $firstItem->path,
            'interviewer' => $firstItem->interviewer,
            'REGION' => $firstItem->REGION,
            'PRÉFECTURE' => $firstItem->PRÉFECTURE,
            'SOUS-PRÉFECTURE/COMMUNE' => $firstItem->{'SOUS-PRÉFECTURE/COMMUNE'},
            'ZS' => $firstItem->ZS,
            'ZC' => $firstItem->ZC
            ];

            // Initialize all dates with 0
            foreach ($allDates as $date) {
            $row[$date] = 0;
            }

            // Fill in actual values
            $group->each(function($item) use (&$row) {
            $date = $item->enumeration_date;
            $row[$date] = ($row[$date] ?? 0) + $item->enum_hh;
            });

            return $row;
            })->values();

        return $pivotData;
    }
}



