<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Project;
use Filament\Widgets\Widget;

class ActivityTimeline extends Widget
{
    protected static string $view = 'filament.widgets.activity-timeline';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 6;

    protected function getViewData(): array
    {
        $recentProjects = Project::latest()->take(3)->get();
        $recentMessages = ContactMessage::latest()->take(3)->get();

        $activities = collect();

        foreach ($recentProjects as $project) {
            $activities->push((object)[
                'type' => 'project',
                'title' => 'New Project Added',
                'description' => $project->title,
                'time' => $project->created_at,
                'icon' => 'heroicon-o-folder',
                'color' => 'success',
            ]);
        }

        foreach ($recentMessages as $message) {
            $activities->push((object)[
                'type' => 'message',
                'title' => 'New Contact Message',
                'description' => "From: {$message->name} - {$message->subject}",
                'time' => $message->created_at,
                'icon' => 'heroicon-o-envelope',
                'color' => 'warning',
            ]);
        }

        return [
            'activities' => $activities->sortByDesc('time')->take(5),
        ];
    }
}
