<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getViewData(): array
    {
        $user = Auth::user();
        $skillsCount = \App\Models\Skill::count();
        $projectsCount = \App\Models\Project::count();
        $messagesCount = \App\Models\ContactMessage::count();

        return [
            'user' => $user,
            'skillsCount' => $skillsCount,
            'projectsCount' => $projectsCount,
            'messagesCount' => $messagesCount,
        ];
    }
}
