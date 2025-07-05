<?php

namespace App\Livewire\Scorecard;

use Illuminate\Support\Collection;
use Uneca\Chimera\Livewire\ScorecardComponent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Uneca\Chimera\Enums\DataStatus;
use Uneca\Chimera\Models\Scorecard;
use Uneca\Chimera\Services\APCA;
use Uneca\Chimera\Services\ColorPalette;
use Uneca\Chimera\Traits\AreaResolver;
use Uneca\Chimera\Traits\Cachable;

abstract class ExtScorecardComponent extends ScorecardComponent
{
    public ?string $dynamicBgColor = null;

    public function mount(int $index)
    {
        $this->title = $this->scorecard->title;
        $currentPalette = ColorPalette::palette(settings('color_palette'));
        $totalColors = count($currentPalette->colors);
        $this->bgColor = '#cfcfcf';
        // $this->fgColor = APCA::decideBlackOrWhiteTextColor($this->bgColor);

        list($this->filterPath,) = $this->areaResolver();
        $this->checkData();
    }
    protected function getNumberFormatter(int $fractionDigits): \NumberFormatter
    {
        $formatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $fractionDigits);
        return $formatter;
    }

    public function setPropertiesFromData(): void
    {
        list($this->dataTimestamp, $data) = Cache::get($this->cacheKey());
        if (($data instanceof Collection) && ($data->count() == 2)) {
            list($this->value, $this->diff) = $data;
            $this->dataStatus = DataStatus::RENDERABLE->value;
        }else if (($data instanceof Collection) && ($data->count() == 3)) {
            list($this->value, $this->diff,$this->dynamicBgColor) = $data;
            $this->bgColor = $this->dynamicBgColor ?? '#cfcfcf';
            $this->fgColor = APCA::decideBlackOrWhiteTextColor($this->bgColor);

            $this->dataStatus = DataStatus::RENDERABLE->value;
        } else {
            $this->dataStatus = DataStatus::EMPTY->value;
        }
    }
}
