<?php

namespace App\Livewire\MenageOrdinaire;

use Uneca\Chimera\Livewire\Chart;
use Illuminate\Support\Collection;
use App\Services\BreakoutQueryBuilder;

class SingleAgePopulation extends Chart
{
    private function polynomialRegression(array $X, array $Y, int $degree = 2): array
    {
        $n = count($X);
        $matrix = [];
        $vector = [];
        for ($row = 0; $row <= $degree; $row++) {
            $matrix[$row] = [];
            for ($col = 0; $col <= $degree; $col++) {
                $matrix[$row][$col] = array_sum(array_map(fn($x) => pow($x, $row + $col), $X));
            }
            $vector[$row] = array_sum(array_map(fn($x, $y) => pow($x, $row) * $y, $X, $Y));
        }
        // Gaussian elimination
        for ($i = 0; $i <= $degree; $i++) {
            $maxRow = $i;
            for ($k = $i+1; $k <= $degree; $k++) {
                if (abs($matrix[$k][$i]) > abs($matrix[$maxRow][$i])) {
                    $maxRow = $k;
                }
            }
            $tmp = $matrix[$i]; $matrix[$i] = $matrix[$maxRow]; $matrix[$maxRow] = $tmp;
            $tmp = $vector[$i]; $vector[$i] = $vector[$maxRow]; $vector[$maxRow] = $tmp;
            for ($k = $i+1; $k <= $degree; $k++) {
                $c = $matrix[$k][$i] / $matrix[$i][$i];
                for ($j = $i; $j <= $degree; $j++) {
                    $matrix[$k][$j] -= $c * $matrix[$i][$j];
                }
                $vector[$k] -= $c * $vector[$i];
            }
        }
        $coeffs = array_fill(0, $degree+1, 0);
        for ($i = $degree; $i >= 0; $i--) {
            $coeffs[$i] = $vector[$i];
            for ($j = $i+1; $j <= $degree; $j++) {
                $coeffs[$i] -= $matrix[$i][$j] * $coeffs[$j];
            }
            $coeffs[$i] /= $matrix[$i][$i];
        }
        return $coeffs;
    }

    public function getData(string $filterPath = ''): Collection
    {
        $data = (new BreakoutQueryBuilder($this->indicator->data_source, $filterPath))
            ->select(["CASE WHEN P05A < 120 THEN P05A ELSE '120' END AS age_range",
                "CASE WHEN P05A < 120 THEN P05A ELSE '120' END AS labels",
                "COUNT(P05A) frequency"])
            ->from(['sect01', 'sect02'])
            ->where(['IS_DELETED in (1,3)', 'I19=1', 'p11=1'])
            ->groupBy(['P05A'])
            ->get();

        // Sort data by age_range (as integer)
        $data = $data->sortBy(function($item) {
            return is_numeric($item->age_range) ? (int)$item->age_range : 999;
        })->values();
        $ages = $data->pluck('age_range')->map(fn($v) => is_numeric($v) ? (int)$v : 65)->all();
        $frequencies = $data->pluck('frequency')->map(fn($v) => (int)$v)->all();
        $n = count($ages);
        if ($n < 2) {
            return $data;
        }
        $coeffs = $this->polynomialRegression($ages, $frequencies, 2);
        $trend = collect($ages)->map(function($x) use ($coeffs) {
            return round(array_reduce(array_keys($coeffs), fn($carry, $i) => $carry + $coeffs[$i]*pow($x, $i), 0), 2);
        });
        $merged = $data->values()->map(function($item, $i) use ($trend) {
            $item->trend = $trend[$i];
            return $item;
        });
        return $merged;
    }
}
