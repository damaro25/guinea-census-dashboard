<?php

namespace App\Reports\MenageOrdinaire;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use App\Services\GinAreaTree;

class EasWithoutBirthRegister extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {
           $sql = (new BreakoutQueryBuilder($this->report->data_source))
            ->select(array_merge(
                [
                "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path",
                "'' AS interviewer",
                "sum(case when P66M IS NOT NULL OR P66F IS NOT NULL then 1 ELSE 0 END) AS birth_count",
                "COUNT(*) AS enum_hh"
                ]
            ))
            ->from(['sect01','sect02'])
            ->where(['IS_DELETED in (1,3)', "I19=1"])
            ->groupBy(["path"])
            ->toSql();

            $sql = "SELECT full_path AS `EA code`, EA.REGION,EA.PREFECTURE AS `PRÉFECTURE`,EA.COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`,EA.`ZS`,EA.`ZC`,D.birth_count, D.enum_hh,path FROM
            ( ". $sql . ") D
                    RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'";

            $data = (new BreakoutQueryBuilder($this->report->data_source))
            ->get($sql);

            $eas = (new GinAreaTree())->getEAs($filterPath,nameOfReferenceValueToInclude:"households");
            $dt = $data->keyBy('path');

        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 1);

        $data = $eas->map(function ($area) use ($dt, $numberFormatter) {
            $actual = $dt[$area->path]->birth_count ?? 0;
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
            $area['Enumerated Hh']=$dt[$area->path]->enum_hh ?? 0;
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

