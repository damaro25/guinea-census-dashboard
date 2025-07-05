<?php

namespace App\Reports\MenageOrdinaire;

use App\Reports\GuineaReport;
use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use App\Services\GinAreaTree;
class EasWithoutDeathRegister extends GuineaReport
{
    public function getData(string $filterPath): Collection
    {
        $sql =  (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
            ->select(['COUNT(*) AS deaths',
                "'' AS interviewer",
                            "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path"])
            ->from(['sect01','sect06'])
            ->where(['is_deleted in (1,3)', "i19=1"])
            ->groupBy(["path"])
            ->toSql();

         $sql_hh = (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
            ->select(['COUNT(*) AS enum_hh',
                "'' AS interviewer",
                            "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path"])
            ->from(['sect01'])
            ->where(['IS_DELETED in (1,3)', "I19=1"])
            ->groupBy(["path"])
            ->toSql();


        $sql = "SELECT full_path AS `EA code`, EA.REGION,EA.PREFECTURE,EA.COMMUNE,EA.`ZS`,EA.`ZC`,D.deaths,H.enum_hh,D.path FROM
                ( ". $sql . ") D INNER JOIN (". $sql_hh . ") H ON D.path=H.path
                RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(H.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'";

        $data = (new BreakoutQueryBuilder($this->report->data_source, $filterPath))
            ->get($sql);

        $eas = (new GinAreaTree())->getEAs($filterPath,nameOfReferenceValueToInclude: 'households');
        $dt = $data->keyBy('path');

        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 1);

        $data = $eas->map(function ($area) use ($dt, $numberFormatter) {
            $actual = $dt[$area->path]->death_count ?? 0;
            $area['Enumerated Hh']=$dt[$area->path]->enum_hh ?? 0;

            if( $actual > 0 || $area['Enumerated Hh'] == 0){
                return false;
            }

            $pathArray = explode('.', $area->path);
            $area['REGION'] = $dt[$area->path]->REGION ?? '';
            $area['PRÉFECTURE'] = $dt[$area->path]->PREFECTURE ?? '';
            $area['SOUS-PRÉFECTURE/COMMUNE'] = $dt[$area->path]->COMMUNE ?? '';
            $area['ZS'] = $dt[$area->path]->ZS ?? '';
            $area['ZC'] = $dt[$area->path]->ZC ?? '';
            $area['EA'] = $area->name;
            $area['Interviewer name'] = $dt[$area->path]->interviewer ?? '';
            $area['Last time synced'] = $dt[$area->path]->last_time ?? '';
            //$area['Enumerated Hh']=$dt[$area->path]->enum_hh ?? 0;
            $area['Target Hh']=$area->value ?? 0;

            return $area;
        })->reject(function ($area) {
            return empty($area);
        });

        $data = $data->map(function ($row) {
            return collect($row->toArray())
            ->only(['REGION','PRÉFECTURE','`SOUS-PRÉFECTURE/COMMUNE`','ZS','ZC','EA', 'Interviewer Name','Enumerated Hh','Target Hh','Last time synced'])
                ->all();
        });

        return $data;

    }
}

