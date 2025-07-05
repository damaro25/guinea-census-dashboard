<?php

namespace App\Services;

use Uneca\Chimera\Models\Area;
use Uneca\Chimera\Models\AreaHierarchy;
use Uneca\Chimera\Services\AreaTree;

class GinAreaTree extends AreaTree
{
    public function getEAs(?string $parentPath = null, string $orderBy = 'name', bool $checksumSafe = false, ?string $nameOfReferenceValueToInclude = null)
    {
        $num_levels = AreaHierarchy::count();
        $h_count = 0;
        if(!empty($parentPath)){
            $h_count = substr_count($parentPath, '.') + 1;
        }
        $ea_level = $num_levels - $h_count;

        $lquery = empty($parentPath) ? "*{{$ea_level}}" : "$parentPath.*{{$ea_level}}";

        if (is_null($nameOfReferenceValueToInclude)) {
            return Area::selectRaw($checksumSafe ? "CONCAT('*', areas.path) AS path, code, name" : 'areas.path, code, name')
                ->whereRaw("path ~ '{$lquery}'")
                ->orderBy($orderBy)
                ->get();
        } else {
            return Area::selectRaw($checksumSafe ? "CONCAT('*', areas.path) AS path, code, name, value" : 'areas.path, code, name, value')
                ->leftJoin('reference_values', 'areas.path', 'reference_values.path')
                ->whereRaw("areas.path ~ '{$lquery}' AND COALESCE(reference_values.indicator, '{$nameOfReferenceValueToInclude}') = '{$nameOfReferenceValueToInclude}'")
                ->orderBy($orderBy)
                ->get();
        }
    }
}
