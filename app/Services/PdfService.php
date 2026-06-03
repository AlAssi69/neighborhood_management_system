<?php

namespace App\Services;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFactory;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

/**
 * Decoupled PDF generation. Knows nothing about Filament or data entry;
 * it only turns HTML / Blade views into print-ready, RTL-aware PDF bytes.
 */
class PdfService
{
    /**
     * Render a Blade view to raw PDF bytes.
     *
     * @param  array<string, mixed>  $data
     */
    public function renderView(string $view, array $data = []): string
    {
        return $this->renderHtml(ViewFactory::make($view, $data)->render());
    }

    /**
     * Render raw HTML to PDF bytes (RTL, Arabic shaping enabled, fully offline).
     *
     * Uses mPDF's bundled DejaVu Sans (Arabic-capable). Qomra TTFs use PostScript
     * outlines and are not supported by mPDF; the web UI loads Qomra separately.
     */
    public function renderHtml(string|View $html): string
    {
        $tempDir = storage_path('app/mpdf-temp');

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0775, true);
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'tempDir' => $tempDir,
            'margin_top' => 18,
            'margin_bottom' => 18,
            'margin_left' => 15,
            'margin_right' => 15,
            'default_font' => 'dejavusans',
        ]);

        $mpdf->SetDirectionality('rtl');

        $mpdf->WriteHTML($html instanceof View ? $html->render() : $html);

        return $mpdf->Output('', Destination::STRING_RETURN);
    }
}
