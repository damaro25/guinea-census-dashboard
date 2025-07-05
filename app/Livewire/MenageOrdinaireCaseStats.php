<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Uneca\Chimera\Livewire\CaseStats;
use App\Services\BreakoutQueryBuilder;
use Uneca\Chimera\Services\QueryFragmentFactory;

class MenageOrdinaireCaseStats extends CaseStats
{
    public function getData(string $filterPath): \Illuminate\Support\Collection
    {
          try {
            $l = (new BreakoutQueryBuilder($this->dataSource->name, $filterPath, excludePartials: false))
                ->select([
                    "COUNT(*) AS total",
                    "SUM(CASE WHEN I19=1 THEN 1 ELSE 0 END) AS complete",
                    "SUM(CASE WHEN I19=2 THEN 1 ELSE 0 END) AS partial",
                    "COUNT(*) - COUNT(DISTINCT `key`) AS duplicate"
                ])
                ->from(['sect01'])
                ->where(['IS_DELETED in (1,3)'])
                ->get()
                ->first();
            $info = ['total' => 'NA', 'complete' => 'NA', 'partial' => 'NA', 'duplicate' => 'NA'];
            if (!is_null($l)) {
                $info['total'] = $l->total;
                $info['complete'] = $l->complete;
                $info['partial'] = $l->partial;
                $info['duplicate'] = $l->duplicate;
            }
            return collect($info);
        } catch (\Exception $exception) {
            logger('Exception in CaseStats:', ['exception' => $exception->getMessage()]);
            return collect();
        }
    }
}
