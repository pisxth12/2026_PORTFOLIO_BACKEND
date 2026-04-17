<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectsByTech extends ChartWidget
{
    protected static ?string $heading = 'Most Used Technologies';
    protected static ?int $sort = 5;

    protected function getData(): array
    {
            $projects = Project::all();
        $techCount = [];

        foreach ($projects as $project) {
        $languages = $project->languages;

        if (is_string($languages)) {
            $languages = json_decode($languages, true);
        }

        if (!is_array($languages)) {
            $languages = [];
        }

        foreach ($languages as $lang) {
            if (!isset($techCount[$lang])) {
                $techCount[$lang] = 0;
            }
            $techCount[$lang]++;
        }
    }


        arsort($techCount);
        $topTech = array_slice($techCount, 0, 6);

        return [
            'datasets' => [
                [
                    'label' => 'Projects Using',
                    'data' => array_values($topTech),
                    'backgroundColor' => '#6366f1',
                    'borderRadius' => 8,
                ],
            ],
            'labels' => array_keys($topTech),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
