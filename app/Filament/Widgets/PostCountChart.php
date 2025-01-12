<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;

class PostCountChart extends ChartWidget
{
    protected static ?string $heading = 'Post Count';

    protected function getData(): array
    {
        // حساب عدد المشاركات في قاعدة البيانات
        $postCount = Post::count();

        // إرجاع البيانات للمخطط الراداري
        return [
            'datasets' => [
                [
                    'label' => 'Total Posts',
                    'data' => [$postCount],  // بيانات عدد المشاركات
                    'backgroundColor' => ['#FF6384'],  // لون الجزء
                    'borderColor' => '#FF6384',  // لون الحدود
                    'borderWidth' => 1,  // عرض الحدود
                ],
            ],
            'labels' => ['Posts'],  // تسميات المحور الأفقي
        ];
    }

    protected function getType(): string
    {
        return 'bar';  // نوع المخطط: مخطط راداري
    }

}
