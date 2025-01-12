<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserCountChart extends ChartWidget
{

    protected static ?string $heading = 'User Roles Distribution';

    protected function getData(): array
    {
        // تعيين قيم افتراضية للتأكد من أن المخطط يظهر
        $employerCount = User::where('role', 'employer')->count() ?: 0; // إذا كانت القيمة صفرًا
        $userCount = User::where('role', 'user')->count() ?: 0; // إذا كانت القيمة صفرًا

        // إرجاع البيانات للمخطط الدائري
        return [
            'datasets' => [
                [
                    'label' => 'User Roles',
                    'data' => [$employerCount, $userCount],  // بيانات توزيع الأدوار
                    'backgroundColor' => ['#FF6384', '#36A2EB'],  // ألوان الأجزاء
                ],
            ],
            'labels' => ['Employer', 'User'],  // تسميات الأجزاء (الدور)
        ];
    }

    protected function getType(): string
    {
        return 'pie';  // نوع المخطط: مخطط دائري
    }


}
