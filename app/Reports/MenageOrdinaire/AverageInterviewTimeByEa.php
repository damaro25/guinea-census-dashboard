<?php

namespace App\Reports\MenageOrdinaire;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;
use App\Services\GinAreaTree;

class AverageInterviewTimeByEa extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {

        $sql = (new BreakoutQueryBuilder($this->report->data_source))
            ->select(array_merge(["AVG(DUREE_INTERVIEW_MINUTES/60) AS tot_time","COUNT(*) AS enum_hh",
            "'' AS interviewer",
            "CONCAT(SUBSTRING(zd_id, 1, 1),'.',LPAD(SUBSTRING(zd_id, 1, 2), 2, '0'),'.',SUBSTRING(zd_id, 1, 4),'.',zs_id,'.',zc_id,'.',zd_id) AS path",
            ]))
           ->from(['sect01'])
           ->where(["DUREE_INTERVIEW_MINUTES IS NOT NULL",
                "DUREE_INTERVIEW_MINUTES > 60",
                "DUREE_INTERVIEW_MINUTES < 7200"])
            ->groupBy(['path'])
        ->toSql();

        $sql = "SELECT full_path AS `EA code`, EA.REGION,EA.PREFECTURE,EA.COMMUNE,EA.`ZS`,EA.`ZC`,D.tot_time,D.enum_hh, D.interviewer,path FROM
                ( ". $sql . ") D
                RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'
                ";
        $data = (new BreakoutQueryBuilder($this->report->data_source ))
            ->get($sql);


        $eas = (new GinAreaTree())->getEAs($filterPath,nameOfReferenceValueToInclude: 'households');
        $dt = $data->keyBy('path');

        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 1);

        $data = $eas->map(function ($area) use ($dt, $numberFormatter) {

            $actual = $dt[$area->path]->enum_hh ?? 0;
            $target = $area->value ?? 0;

            $area->avg = 0;
            $area->tot_time = 0;
            $area->enum_hh = 0;
            if (isset($dt[$area->path])) {
                $area->avg = $dt[$area->path]->tot_time;
            }

            $area['REGION'] = $dt[$area->path]->REGION ?? '';
            $area['PRÉFECTURE'] = $dt[$area->path]->PREFECTURE ?? '';
            $area['SOUS-PRÉFECTURE/COMMUNE'] = $dt[$area->path]->COMMUNE ?? '';
            $area['ZS'] = $dt[$area->path]->ZS ?? '';
            $area['ZC'] = $dt[$area->path]->ZC ?? '';
            $area['EA'] = $area->name;
            $area['Interviewer Name'] = $dt[$area->path]->interviewer ?? '';
            $area['Average Interview Time (min)'] = $numberFormatter->format($area->avg ?? 0);
            $area['Enumerated HHs'] = $actual;
            $area['Target'] = $target;
            $area['Performance(%)'] = $numberFormatter->format(SafeDivide($actual, $target) * 100) ;
            return $area;
        });
        $data = $data->map(function ($row) {
            return collect($row->toArray())
                ->only(['REGION','PRÉFECTURE','`SOUS-PRÉFECTURE/COMMUNE`','ZS','ZC','EA', 'Interviewer Name', 'Average Interview Time (min)','Enumerated HHs', 'Target', 'Performance(%)'])
                ->all();
        });

        return $data;

    }
}
