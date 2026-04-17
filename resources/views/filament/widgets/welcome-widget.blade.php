<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">
                    Welcome back, {{ $user->name }}! 👋
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Your portfolio is performing well. Here's what's happening today.
                </p>
            </div>
            <div class="flex gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary-600">{{ $skillsCount }}</div>
                    <div class="text-xs text-gray-500">Skills</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-success-600">{{ $projectsCount }}</div>
                    <div class="text-xs text-gray-500">Projects</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-warning-600">{{ $messagesCount }}</div>
                    <div class="text-xs text-gray-500">Messages</div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
