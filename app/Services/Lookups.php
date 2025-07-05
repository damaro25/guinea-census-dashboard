<?php

namespace App\Services;

use Illuminate\Support\Collection;

trait Lookups
{
    private array $urbanRural = [
        1 => 'Urban',
        99 => 'Rural'
    ];

    private array $sex = [
        1 => 'Male',
        2 => 'Female'
    ];

    function pivotCollection($collection, $groupByFields, $keyField, $valueField)
    {
        $groupByFields = (array) $groupByFields; // Ensure $groupByFields is an array
        return collect($collection) // Ensure input is a collection
        ->groupBy(function ($item) use ($groupByFields) {
            // Create a composite key for grouping by multiple fields
            return collect($groupByFields)
                ->map(fn($field) => is_array($item) ? $item[$field] : $item->$field)
                ->join('-');
        })
            ->map(function ($group) use ($groupByFields, $keyField, $valueField) {
                // Add all group-by fields to the result row
                $groupedFields = collect($groupByFields)->mapWithKeys(function ($field) use ($group) {
                    $first = $group->first();
                    return [$field => is_array($first) ? $first[$field] : $first->$field];
                });

                return $group
                    ->pluck($valueField, $keyField) // Pivot 'key' into columns with 'value'
                    ->merge($groupedFields); // Add the grouped fields back into the row
            })
            ->values()->flatMap(function ($item) {
                return [$item->toArray()];
            });

    }

    function leftJoinWithLookup($collection, $keyField, $valueField, $lookup)
    {
        $collection = collect($collection)->map(function ($item) use ($keyField, $valueField, $lookup) {
            $item->$valueField = $lookup[$item->$keyField] ?? 'Unspecified';
            return $item;
        });

        foreach ($lookup as $key => $value) {
            if (!$collection->contains($keyField, $key)) {
                $collection->push((object) [
                    $keyField => $key,
                    $valueField => $value
                ]);
            }
        }

        return $collection;
    }

}
