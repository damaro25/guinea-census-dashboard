<?php

namespace App\Reports\MenageOrdinaire;

use App\Reports\GuineaReport;
use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;
use App\Services\GinAreaTree;

class AverageHhSizeByEa extends GuineaReport
{
    public function getData(string $filterPath): Collection
    {
        $sql = (new BreakoutQueryBuilder($this->report->data_source))
            ->select(array_merge(["COUNT(*) AS population, count(distinct sect01.`sect01-id`) households",
            "'' AS interviewer",
            "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path",
            ]))
           ->from(['sect01','sect02'])
           ->where(['IS_DELETED in (1,3)', 'I19=1'])
           ->groupBy(['path'])
           ->toSql();

        $sql = "SELECT full_path AS `EA code`,EA.REGION,EA.PREFECTURE,EA.COMMUNE,EA.`ZS`,EA.`ZC`,D.population, D.households, D.interviewer,path FROM
                ( ". $sql . ") D
                RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'
                ";
        $data = (new BreakoutQueryBuilder($this->report->data_source ))
            ->get($sql);

        $eas = (new GinAreaTree())->getEAs($filterPath, nameOfReferenceValueToInclude: 'households');
        $dt = $data->keyBy('path');

        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 1);

        $data = $eas->map(function ($area) use ($dt, $numberFormatter) {

            $actual = $dt[$area->path]->households ?? 0;
            $target = $area->value ?? 0;

            $area->population = $dt[$area->path]->population ?? 0;
            $area->households = $dt[$area->path]->households ?? 0;
            $area->avg = $numberFormatter->format(SafeDivide($area->population, $area->households)) ;

            $pathArray = explode('.', $area->path);
            $area['REGION'] = $dt[$area->path]->REGION ?? '';
            $area['PRÉFECTURE'] = $dt[$area->path]->PREFECTURE ?? '';
            $area['SOUS-PRÉFECTURE/COMMUNE'] = $dt[$area->path]->COMMUNE ?? '';
            $area['ZS'] = $dt[$area->path]->ZS ?? '';
            $area['ZC'] = $dt[$area->path]->ZC ?? '';
            $area['EA'] = $area->name;
            $area['Interviewer Name'] = $dt[$area->path]->interviewer ?? '';
            $area['Average household size'] = $area->avg ?? 0;
            $area['Enumerated population'] = $area->population;
            $area['Enumerated HHs'] = $area->households;
            $area['Target'] = $target;
            $area['Performance(%)'] = $numberFormatter->format(SafeDivide($actual, $target) * 100) ;
            return $area;
        });
        $data = $data->map(function ($row) {
            return collect($row->toArray())
                ->only(['REGION','PRÉFECTURE','`SOUS-PRÉFECTURE/COMMUNE`','ZS','ZC','EA', 'Interviewer Name', 'Average household size','Enumerated population','Enumerated HHs', 'Target', 'Performance(%)'])
                ->all();
        });

        return $data;

    }
}
