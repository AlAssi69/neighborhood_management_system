<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\Family;
use App\Models\Person;
use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NeighborhoodStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي السكان', Person::query()->count())
                ->description('عدد الأشخاص المسجلين')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('عدد العائلات', Family::query()->count())
                ->description('بطاقات العائلة المسجلة')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('المحال التجارية', Business::query()->count())
                ->description('السجلات التجارية النشطة')
                ->descriptionIcon('heroicon-o-building-storefront')
                ->color('success'),

            Stat::make('العقارات', Property::query()->count())
                ->description('العقارات المسجّلة في النظام')
                ->descriptionIcon('heroicon-o-home-modern')
                ->color('warning'),
        ];
    }
}
