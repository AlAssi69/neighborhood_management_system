<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDF font directories (mPDF)
    |--------------------------------------------------------------------------
    |
    | Cairo (body) and converted Qomra (headings) live under resources/fonts/pdf.
    | Regenerate Qomra with: python scripts/convert-qomra-for-mpdf.py
    |
    */

    'cairo' => [
        'dir' => resource_path('fonts/pdf/cairo'),
        'regular' => 'Cairo-Regular.ttf',
        'bold' => 'Cairo-Bold.ttf',
    ],

    'qomra' => [
        'dir' => resource_path('fonts/pdf/qomra'),
        'regular' => 'Qomra-Regular-mpdf.ttf',
        'bold' => 'Qomra-Black-mpdf.ttf',
    ],

];
