<?php

namespace App\Filament\Widgets;

use App\Models\Skill;
use Filament\Widgets\ChartWidget;

class SkillsChart extends ChartWidget
{
    protected static ?string $heading = 'Skills by Category';
    protected static ?int $sort = 4;

    protected function getData(): array
    {

            $categories = Skill::select('category')
                ->selectRaw('count(*) as count')
                ->groupBy('category')
                ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Skills',
                    'data' => $categories->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'
                    ],
                ],
            ],
            'labels' => $categories->pluck('category')->toArray(),
        ];
    }


    protected function getType(): string
    {
        return 'doughnut';
    }
}
