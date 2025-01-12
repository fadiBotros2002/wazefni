<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {


        $realData = Trend::model(User::class)
        ->between(
            start: now()->subMonths(1)->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perMonth()
        ->count();


        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => $realData->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $realData->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
