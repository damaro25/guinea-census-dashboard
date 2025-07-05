@push('scripts')
    @vite(['resources/css/map.css', 'resources/js/map.js'])
@endpush

<div class="w-full py-6 px-4 sm:px-6 lg:px-8">
    <x-chimera::simple-card>
        <div class="flex flex-col lg:flex-row gap-6 relative z-0">
            <div class="flex-1">
                <div
                    id="map"
                    data-map-options='@json($leafletMapOptions)'
                    data-indicators='@json($indicators)'
                    data-levels='@json($levels)'
                    data-styles='@json($allStyles)'
                    wire:ignore
                    style="height: 75vh;"
                ></div>
                <div wire:loading class="absolute inset-1/2 -ml-12 -mt-6 h-12 w-48 bg-gray-500 text-white text-lg px-4 py-2 rounded-full z-[401]">Loading map data...</div>
            </div>
            <div class="w-full lg:w-1/3 bg-white rounded shadow p-4 overflow-auto max-h-[75vh]">
                <h2 class="text-lg font-semibold mb-4">
                    @if(isset($leafData[0]['level']))
                        {{ $leafData[0]['level'] }}
                    @endif
                </h2>
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr>
                            @if(isset($leafData[0]['columns']))
                            @foreach($leafData[0]['columns'] as $col)
                                <th class="px-2 py-1 border-b">{{ $col }}</th>
                            @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leafData as $row)
                            <tr>
                                <td class="px-2 py-1 border-b flex items-center gap-2">
                                    <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $row['color'] }};"></span>
                                    {{ $row['ea_number'] }}
                                </td>
                                <td class="px-2 py-1 border-b">
                                    {{ $row['staff_name'] }}
                                </td>
                                <td class="px-2 py-1 border-b">{{ $row['value'] }}</td>
                            </tr>
                        @endforeach
                        <!-- Add more rows dynamically as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </x-chimera::simple-card>
</div>
