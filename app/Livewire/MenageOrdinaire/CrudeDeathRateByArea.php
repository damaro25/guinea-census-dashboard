<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class CrudeDeathRateByArea extends Chart
{
    public bool $useDynamicAreaXAxisTitles = true;
    public function getData(string $filterPath): Collection
    {
        $deaths =  (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select(['COUNT(*) AS deaths'])
            ->from(['sect01','sect06'])
            ->where(['IS_DELETED in (1,3)', 'I19=1'])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData(
                referenceValueToInclude: 'death_rate',
            )
            ->get();

        $pop = (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select([
                "COUNT(*) AS total"])
            ->from(['sect01','sect02'])
            ->where(['IS_DELETED in (1,3)', 'I19=1', 'p11=1'])
            ->groupBy(['area_code'])
            ->lastlyAreaLeftJoinData()
            ->get();

        $popByKey = $pop->keyBy('area_code');
        $data = $deaths->map(function ($row)  use( $popByKey) {
            $row->expected = 4.4; //Source: World Population Prospects: The 2024 Revision
            $row->total = $popByKey->get($row->area_code)->total ?? 0;
            $row->rate = safeDivide($row->deaths, $row->total) * 1000 ;
            return $row;
        });
        return $data;
    }
}
