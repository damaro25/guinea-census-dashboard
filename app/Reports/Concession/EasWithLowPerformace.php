<?php

namespace App\Reports\Concession;

use Uneca\Chimera\Report\ReportBaseClass;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;
use App\Services\GinAreaTree;
use Carbon\Carbon;

class EasWithLowPerformace extends ReportBaseClass
{
    public function getData(string $filterPath): Collection
    {

        //list(, $whereConditions) = QueryFragmentFactory::make($this->report->questionnaire)->getSqlFragments($filterPath);

        $questionnaire = $this->report->getDataSource();
        $now = Carbon::now();
        $startDate = $questionnaire->start_date->subDays(1);
        $endDate = $questionnaire->end_date;

        $total_Enum_days=$startDate->diffInDays($endDate,false);
        $days_Since_enum_start=$startDate->diffInDays($now,false);
        $day_count_yesterday=$startDate->diffInDays($now,false) - 1;

        if($days_Since_enum_start > $total_Enum_days) {
            $days_Since_enum_start = $total_Enum_days;
        }
        $days_Since_enum_start= $days_Since_enum_start <= 0 ? 1 : $days_Since_enum_start;


        if($day_count_yesterday > $total_Enum_days) {
            $day_count_yesterday = $total_Enum_days;
        }

        $sql = (new BreakoutQueryBuilder($this->report->data_source,$filterPath))
            ->select(
                ["CONCAT(SUBSTRING(cons_zd_id, 1, 1),'.',LPAD(SUBSTRING(cons_zd_id, 1, 2), 2, '0'),'.',SUBSTRING(cons_zd_id, 1, 4),'.',cons_zs_id,'.',cons_zc_id,'.',cons_zd_id) AS `path`",
                "COUNT(*) AS listed_str","'' AS interviewer"]
            )
            ->from(['cons_infra_rec'])
            ->where(['CONS_IS_DELETED in (1,3)'])
            ->groupBy(["path"])
            ->toSql();

            $sql= "SELECT EA.REGION,EA.PREFECTURE,EA.COMMUNE,EA.`ZS`,EA.`ZC`,D.interviewer,D.listed_str,path FROM
            ( ". $sql . ") D
                    RIGHT JOIN gn_ea_frames.ea_hierarchy_names EA ON CONVERT(EA.full_path USING utf8mb4)=CONVERT(D.path USING utf8mb4) AND EA.full_path LIKE '$filterPath%'
            ";


            $data = (new BreakoutQueryBuilder($this->report->data_source,$filterPath))
                ->get($sql);


        $eas = (new GinAreaTree())->getEAs($filterPath, nameOfReferenceValueToInclude: 'households');
        $dt = $data->keyBy('path');

        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 3);

        $data = $eas->map(function ($area) use ($dt, $numberFormatter,$days_Since_enum_start, $total_Enum_days) {
            $actual = $dt[$area->path]->listed_str ?? 0;
            $target = $area->value==null ? 0: SafeDivide($days_Since_enum_start, $total_Enum_days) *$area->value;
            $performance = $numberFormatter->format(SafeDivide($actual, $target) * 100) ;

            if( $performance > 10 || $target == 0){
                return false;
            }

            $area['REGION'] = $dt[$area->path]->REGION ?? '';
            $area['PRÉFECTURE'] = $dt[$area->path]->PREFECTURE ?? '';
            $area['SOUS-PRÉFECTURE/COMMUNE'] = $dt[$area->path]->COMMUNE ?? '';
            $area['ZS'] = $dt[$area->path]->ZS ?? '';
            $area['ZC'] = $dt[$area->path]->ZC ?? '';
            $area['ZD'] = $area->path;
            $area['Listed structure'] = $actual;
            $area['Target'] = $area->value ?? 0;
            $area['Interviewer'] = $dt[$area->path]->interviewer ?? '';
            $area['Performance(%)'] = $performance ;
            return $area;
        })->reject(function ($area) {
            return empty($area);
        });

        $data = $data->map(function ($row) {
            return collect($row->toArray())
                ->only(['REGION','PRÉFECTURE','COMMUNE AS `SOUS-PRÉFECTURE/COMMUNE`','ZS','ZC','ZD', 'Interviewer','Listed structure', 'Target', 'Performance(%)'])
                ->all();
        });

        return $data;
    }
}
