<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\IncomeByAreaChart;
use App\Filament\Widgets\NeighborhoodStatsOverview;
use App\Models\Person;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return 'لوحة المعلومات';
    }

    public function getWidgets(): array
    {
        return [
            NeighborhoodStatsOverview::class,
            IncomeByAreaChart::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportStats')
                ->label('تصدير الإحصائيات (CSV)')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn (): StreamedResponse => $this->exportStats()),
        ];
    }

    /**
     * Export raw income statistics grouped by real-estate area as CSV.
     */
    protected function exportStats(): StreamedResponse
    {
        $rows = [];

        Person::query()
            ->with(['properties.realEstateArea'])
            ->chunk(200, function ($people) use (&$rows): void {
                foreach ($people as $person) {
                    $areas = $person->properties
                        ->map(fn ($property) => $property->realEstateArea?->name)
                        ->filter()
                        ->unique();

                    if ($areas->isEmpty()) {
                        $areas = collect(['غير محدد']);
                    }

                    foreach ($areas as $area) {
                        if (! isset($rows[$area])) {
                            $rows[$area] = ['population' => 0, 'income' => 0.0];
                        }

                        $rows[$area]['population']++;
                        $rows[$area]['income'] += (float) $person->income;
                    }
                }
            });

        $filename = 'neighborhood-stats-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($rows): void {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Excel renders Arabic correctly.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['المنطقة العقارية', 'عدد السكان', 'إجمالي الدخل', 'متوسط الدخل']);

            foreach ($rows as $area => $data) {
                $average = $data['population'] > 0 ? $data['income'] / $data['population'] : 0;

                fputcsv($handle, [
                    $area,
                    $data['population'],
                    number_format($data['income'], 2, '.', ''),
                    number_format($average, 2, '.', ''),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
