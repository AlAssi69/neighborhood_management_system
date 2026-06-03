<?php

namespace App\Filament\Widgets;

use App\Models\Person;
use Filament\Widgets\ChartWidget;

class IncomeByAreaChart extends ChartWidget
{
    protected ?string $heading = 'إجمالي الدخل حسب المنطقة العقارية';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Sum each person's income once per distinct real-estate area they
        // are linked to (via their properties), so a person with two
        // properties in the same area is not double counted.
        $totals = [];

        Person::query()
            ->with(['properties:id,real_estate_area'])
            ->whereNotNull('income')
            ->chunk(200, function ($people) use (&$totals): void {
                foreach ($people as $person) {
                    $areas = $person->properties
                        ->pluck('real_estate_area')
                        ->filter()
                        ->unique();

                    foreach ($areas as $area) {
                        $totals[$area] = ($totals[$area] ?? 0) + (float) $person->income;
                    }
                }
            });

        arsort($totals);

        if ($totals === []) {
            $totals = ['لا توجد بيانات' => 0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'إجمالي الدخل (₪)',
                    'data' => array_values($totals),
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#b45309',
                ],
            ],
            'labels' => array_keys($totals),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
