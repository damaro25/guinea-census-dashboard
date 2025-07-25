<div x-data="{ status: $wire.entangle('dataStatus') }" x-init="dataStatus = 'pending'">

    <div x-show="status == 'pending'" x-cloak>
        <div wire:poll.visible.3s="checkData"></div>

        @include('chimera::livewire.placeholders.scorecard')
    </div>

    <div x-show="status == 'renderable'" x-cloak x-transition.duration.1000ms>
        <div class="flex flex-col p-3 text-center rounded-md shadow-sm opacity-90 relative" style="background-color: {{ $dynamicBgColor??$bgColor }};">
            @if(! empty($scorecard->linked_indicator))
                <a href="{{ route('indicator', $scorecard->linked_indicator) }}?linked_from_scorecard" class="absolute right-1 top-1">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            @endif
            <div class="absolute left-1 top-1 opacity-60 cursor-pointer" title="Calculated {{ $dataTimestamp?->diffForHumans() }} ({{ $dataTimestamp?->toDayDateTimeString() }})">
                <x-chimera::icon.stamp class="text-gray-600" />
            </div>
            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-wrap flex items-center justify-center text-center {{ $fgColor }}" style="min-height: 3.5rem;">
                {{ $title }}
            </dt>
            <dd class="order-1 text-3xl font-extrabold {{ $fgColor }} flex justify-center items-center">
                <div class="mr-2"><span wire:loading>...</span>{{ $value }}</div>
                @if (! is_null($diff))
                    <x-chimera::stock-ticker diff="{{ $diff }}" diff-title="" unit="{{ $unit }}" />
                @endif
            </dd>
        </div>
    </div>

    <div x-show="status == 'empty'" x-cloak>
        <div class="flex flex-col p-3 text-center rounded-md shadow-sm opacity-90 relative" style="background-color: {{ $dynamicBgColor??$bgColor }};">
            <dt class="order-2 mt-2 text-lg leading-6 font-medium truncate {{ $fgColor }}">
                {{ $title }}
            </dt>
            <dd class="order-1 text-3xl font-extrabold {{ $fgColor }} flex justify-center items-center">
                <div class="mr-2">{{ __('N/A') }}</div>
            </dd>
        </div>
    </div>

</div>

