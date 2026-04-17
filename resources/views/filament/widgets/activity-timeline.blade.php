<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium">Recent Activity</h3>
            <span class="text-xs text-gray-500">Last 5 updates</span>
        </div>

        <div class="space-y-4">
            @foreach($activities as $activity)
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="p-2 rounded-full bg-{{ $activity->color }}-100 dark:bg-{{ $activity->color }}-900/20">
                            <x-filament::icon
                                name="{{ $activity->icon }}"
                                class="w-4 h-4 text-{{ $activity->color }}-600"
                            />
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $activity->title }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $activity->description }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $activity->time->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
