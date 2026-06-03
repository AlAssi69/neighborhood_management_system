<?php

namespace App\Services;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
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
        return $this->renderHtml(
            ViewFactory::make($view, array_merge($data, $this->pdfViewData()))->render()
        );
    }

    /**
     * Render raw HTML to PDF bytes (RTL, Arabic shaping, Syrian brand fonts).
     */
    public function renderHtml(string|View $html): string
    {
        $tempDir = storage_path('app/mpdf-temp');

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0775, true);
        }

        $mpdf = new Mpdf(array_merge([
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl',
            'autoScriptToLang' => false,
            'autoLangToFont' => false,
            'tempDir' => $tempDir,
            'margin_top' => 18,
            'margin_bottom' => 18,
            'margin_left' => 15,
            'margin_right' => 15,
        ], $this->mpdfFontConfig()));

        $mpdf->SetDirectionality('rtl');

        $mpdf->WriteHTML($html instanceof View ? $html->render() : $html);

        return $mpdf->Output('', Destination::STRING_RETURN);
    }

    /**
     * Variables passed into every PDF Blade view (typography family names for CSS).
     *
     * @return array{pdfBodyFont: string, pdfHeadingFont: string}
     */
    public function pdfViewData(): array
    {
        $fonts = $this->resolvedFonts();

        return [
            'pdfBodyFont' => $fonts['body'],
            'pdfHeadingFont' => $fonts['heading'],
        ];
    }

    /**
     * @return array{body: string, heading: string, fontDir: list<string>, fontdata: array<string, array<string, string>>, default_font: string}
     */
    protected function resolvedFonts(): array
    {
        $cairo = config('pdf.cairo');
        $qomra = config('pdf.qomra');

        $fontDir = [];
        $fontdata = [];
        $body = 'cairo';

        $cairoRegular = $cairo['dir'].'/'.$cairo['regular'];
        if (is_readable($cairoRegular)) {
            $fontDir[] = $cairo['dir'];
            $fontdata['cairo'] = [
                'R' => $cairo['regular'],
                'B' => $cairo['bold'],
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ];
        }

        $qomraRegular = $qomra['dir'].'/'.$qomra['regular'];
        $heading = 'cairo';

        if (is_readable($qomraRegular)) {
            $fontDir[] = $qomra['dir'];
            $fontdata['qomra'] = [
                'R' => $qomra['regular'],
                'B' => $qomra['bold'],
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ];
            $heading = 'qomra';
        } else {
            Log::warning('Qomra PDF fonts missing; headings will use Cairo Bold. Run: python scripts/convert-qomra-for-mpdf.py');
        }

        if ($fontdata === []) {
            throw new \RuntimeException('No PDF fonts found in resources/fonts/pdf. See README.md.');
        }

        return [
            'body' => $body,
            'heading' => $heading,
            'fontDir' => $fontDir,
            'fontdata' => $fontdata,
            'default_font' => $body,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function mpdfFontConfig(): array
    {
        $fonts = $this->resolvedFonts();

        return [
            'fontDir' => $fonts['fontDir'],
            'fontdata' => $fonts['fontdata'],
            'default_font' => $fonts['default_font'],
        ];
    }
}
