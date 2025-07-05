    <div class="w-44 max-h-96">

    <div class="px-4 sm:px-0">
      <h3 class="text-base font-semibold leading-7 text-gray-900">{{ $area->area_name }}</h3>
      <div class="bg-orange-400 bg-red-500 bg-green-500 hidden"></div>
    </div>
    <div class="mt-2 border-t border-gray-500">
      <dl class="divide-y divide-gray-400">
        <div class="px-4 pt-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-900 ">{{__('Performance actual')}}:</dt>
          <dd class="mt-2 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 text-right ">
            {{$numberFormatter->format($area->performance)}} %
            <div class="overflow-hidden rounded-full bg-gray-200">
                <div class="h-4 bg-{{$selectedColor}}-500 {{$area->style}}" style="width: {{$area->performance}}%"></div>
              </div>
            </dd>
        </div>
      </dl>
      <dl class="divide-y divide-gray-500">
        <div class="px-4 pt-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-900">{{__("Today's target")}}:</dt>
          <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 text-right">{{$numberFormatter->format($area->expected)}} %</dd>
        </div>
      </dl>
      <dl class="divide-y divide-gray-400">
        <div class="px-4 pt-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-900">{{__("Completed")}}:</dt>
          <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 text-right">{{$area->total}}</dd>
        </div>
      </dl>
      <dl class="divide-y divide-gray-400">
        <div class="px-4 pt-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-900">{{__("Target")}}:</dt>
          <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 text-right">{{$area->expected}}</dd>
        </div>
      </dl>
    </div>
  </div>

