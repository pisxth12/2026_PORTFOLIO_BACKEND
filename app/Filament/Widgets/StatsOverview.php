<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Skills', Skill::count())
                ->description('Technologies mastered')
                ->descriptionIcon('heroicon-m-code-bracket')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Projects', Project::count())
                ->description('Completed & ongoing')
                ->descriptionIcon('heroicon-m-folder')
                ->color('info')
                ->chart([3, 5, 2, 8, 4, 6, 5]),

            Stat::make('Contact Messages', ContactMessage::count())
                ->description('Total inquiries')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning')
                ->chart([1, 3, 2, 4, 1, 2, 3]),

            Stat::make('Projects with GitHub', Project::whereNotNull('github')->count())
                ->description('Open source')
                ->descriptionIcon('heroicon-m-link')
                ->color('danger')
                ->chart([2, 4, 1, 3, 5, 2, 4]),
        ];
    }
}
