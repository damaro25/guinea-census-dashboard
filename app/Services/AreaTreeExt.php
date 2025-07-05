<?php

namespace App\Services;

use Uneca\Chimera\Models\Area;
use Uneca\Chimera\Services\AreaTree;

class AreaTreeExt extends AreaTree
{
        public function areas(?string $parentPath = null, string $orderBy = 'name', bool $checksumSafe = false, ?string $nameOfReferenceValueToInclude = null)
    {
        $lquery = empty($parentPath) ? '*{1}' : "$parentPath.*{1}";
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

    public function leaf(?string $parentPath = null, string $level = null,string $orderBy = 'name', bool $checksumSafe = false, ?string $nameOfReferenceValueToInclude = null,bool $includeAncestors = false)
    {
        $lquery = empty($parentPath) ? '*{1}' : "$parentPath.*{1}";
        $level = is_null($level) ? Area::max('level') : $level;
        if (is_null($nameOfReferenceValueToInclude)) {
            return Area::selectRaw(($checksumSafe ? "CONCAT('*', areas.path) AS path, code, name" : "areas.path, code, name").
            ($includeAncestors ? ",areas.level,array_to_json(array(select p.name from areas as p where p.path @> areas.path order by p.path)) as ancestor_names" : ''))
                ->whereRaw("path <@ '{$parentPath}' AND areas.level = {$level}")
                ->orderBy($orderBy)
                ->get();
        } else {
            return Area::selectRaw(($checksumSafe ? "CONCAT('*', areas.path) AS path, code, name, value" : 'areas.path, code, name, value').
            ($includeAncestors ? ",areas.level,array_to_json(array(select p.name from areas as p where p.path @> areas.path order by p.path)) as ancestor_names" : ''))
                ->leftJoin('reference_values', 'areas.path', 'reference_values.path')
                ->whereRaw("areas.path <@ '{$parentPath}' And areas.level = {$level}  AND COALESCE(reference_values.indicator, '{$nameOfReferenceValueToInclude}') = '{$nameOfReferenceValueToInclude}'")
                ->orderBy($orderBy)
                ->get();
        }

    }

    public function getAncestors(string $path): array
    {
        $ancestors = [];
        $currentPath = str($path);
        $hierarchies = (new AreaTree())->hierarchies;
        while ($currentPath->contains('.')) {
            $currentPath = $currentPath->beforeLast('.');
            $ancestor = Area::where('path', $currentPath)->first();
            if ($ancestor) {
                $levelName = isset($hierarchies[$ancestor->level]) ? $hierarchies[$ancestor->level] : $ancestor->level;
                $ancestors[] = [
                    'area' => $ancestor,
                    'level_name' => $levelName
                ];
            }
        }
        return $ancestors;
    }
    public function getAreasByLevel(string $level){
        return Area::where('level', $level)
            ->orderBy('name')
            ->get(['path', 'code', 'name']);
    }

}
