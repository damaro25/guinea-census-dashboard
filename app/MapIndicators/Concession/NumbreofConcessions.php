<?php

namespace App\MapIndicators\Concession;

use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Uneca\Chimera\MapIndicator\MapIndicatorBaseClass;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Models\AreaHierarchy;

class NumbreofConcessions extends MapIndicatorBaseClass
{
    public array $bins = [0, 80, 95, 1000];
    public string $level = "";
    public array $columns = [];

    const SELECTED_COLOR_CHART = 'rag';
    public string $displayValueField ='use this';

    public function getData(string $filterPath): Collection
    {

        $data =  (new BreakoutQueryBuilder($this->mapIndicator->data_source, $filterPath))
            ->select(["SUM(CONS_MEN_ORD_CENSUS) AS total","SUM(CONS_MEN_ORD_CARTO) ref_value"])
            ->from(['cons_infra_rec'])
            ->where(['CONS_IS_DELETED in (1,3)',])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData(referenceValueToInclude: 'households')
            ->get()->map(
                function ($item){
                    $item->info = $item->area_name?? null;
                    $item->use_this = "{$item->total} of {$item->ref_value}";
                    $item->value = Number::format(safeDivide($item->total??null,$item->ref_value??null) *100,1);
                    $item->ref_value = (int) $item->ref_value;
                    $item->use_this = "{item->value}% ($item->use_this)";
                    return $item;
                }
            )
        ;
        return $data;
        
    }

    public function getLeafData(string $path, int $level): array
    {
        if ($level < 3) {
            $this->level = AreaHierarchy::where('index', $level)->first()->name;
            $this->columns = [
                $this->level.' Code',
                $this->level.' Name',
                'Couverture (%)',
            ];
        $query = (new BreakoutQueryBuilder($this->mapIndicator->data_source, $path))
            ->select(['SUM(CONS_MEN_ORD_CENSUS) as total'])
            ->from(['cons_infra_rec'])
            ->where(["CONS_IS_DELETED in (1,3)"])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData(referenceValueToInclude: 'households')
            ->get()->map(
                function ($item){
                    $item->info = $item->area_name?? null;
                    $item->use_this = "{$item->total} of {$item->ref_value}";
                    $item->value = Number::format(safeDivide($item->total??null,$item->ref_value??null) *100,1);
                    $item->ref_value = (int) $item->ref_value;
                    $item->use_this = "{item->value}% ($item->use_this)";
                    return $item;
                }
            );            // Map the results to the expected array structure
            return $query->map(function ($item) {
                return [
                    'ea_number' => $item->area_name,
                    'value' => $item->value,
                    'color' => $item->value > 95 ? 'green' : ($item->value > 80 ? 'yellow' : 'red'),
                    'display_value' => $item->use_this,
                    'staff_name' => $item->area_name ?? 'Unknown',
                    'level' => $this->level,
                    'columns' => $this->columns,
                ];
            })->toArray();
        }
        $this->level = "ZD's";
        // Query the database for real EA data at the given path and level
        $query = (new BreakoutQueryBuilder($this->mapIndicator->data_source, $path))
            ->select(['CONS_ZD_ID ea_number','SUM(CONS_MEN_ORD_CARTO) ref_value','SUM(CONS_MEN_ORD_CENSUS) as total'])
            ->from(['cons_infra_rec'])
            ->where(["CONS_IS_DELETED in (1,3)"])
            ->groupBy(['ea_number'])
            ->toSql();

        $sql = "Select area_code,subquery.ea_number,subquery.ref_value,subquery.total,staff.staff_name from ({$query}) as subquery
        join brk_gn_staff.gn_staff_rec as staff on subquery.ea_number = staff.staff_zd
        ";
        // dump($sql);
        $data = (new BreakoutQueryBuilder($this->mapIndicator->data_source, $path))
            ->get($sql);
        $data = $data->map(
                function ($item){
                    $item->use_this = "{$item->total} of {$item->ref_value}";
                    $item->value = Number::format(safeDivide($item->total??null,$item->ref_value??null) *100,1);
                    $item->ref_value = (int) $item->ref_value;
                    $item->use_this = "{item->value}% ($item->use_this)";
                    $item->staff_name = $item->staff_name ?? 'Unknown';
                    return $item;
                }
            );


        // Map the results to the expected array structure
        return $data->map(function ($item) {
            return [
                'ea_number' => $item->ea_number,
                'value' => $item->value,
                'color' => $item->value > 95 ? 'green' : ($item->value > 80 ? 'yellow' : 'red'),
                'display_value' => $item->use_this,
                'staff_name' => $item->staff_name,
                'level' => $this->level,
                'columns' => [
                    'ZD Number',
                    'Staff Name',
                    'Coverage (%)',
                ],
            ];
        })->toArray();
    }


    public function getDisplayValue($item): string
    {
        return $item->use_this;
    }
}
