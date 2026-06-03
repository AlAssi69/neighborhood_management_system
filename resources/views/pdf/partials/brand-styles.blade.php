{{-- Syrian visual identity for mPDF — mirrors syrian-tokens.css (plain values; mPDF has no var() support) --}}
<style>
    body {
        font-family: {{ $pdfBodyFont ?? 'cairo' }}, sans-serif;
        direction: rtl;
        text-align: right;
        color: #161616;
        font-size: 12px;
        line-height: 1.7;
        background-color: #ffffff;
    }

    .sy-letterhead {
        text-align: center;
    }

    .sy-letterhead--top {
        border-bottom: 2px solid #b9a779;
        padding-bottom: 12px;
        margin-bottom: 14px;
    }

    .sy-letterhead img {
        max-width: 320px;
        height: auto;
        margin-bottom: 8px;
    }

    .sy-letterhead__line {
        font-family: {{ $pdfHeadingFont ?? 'qomra' }}, {{ $pdfBodyFont ?? 'cairo' }}, sans-serif;
        font-weight: bold;
        color: #042623;
        margin: 4px 0;
        line-height: 1.35;
    }

    .sy-letterhead__line--republic {
        font-size: 24px;
        margin-bottom: 4px;
    }

    .sy-letterhead__line--ministry {
        font-size: 18px;
        margin-bottom: 2px;
    }

    .sy-letterhead__line--directorate {
        font-family: {{ $pdfBodyFont ?? 'cairo' }}, sans-serif;
        font-weight: normal;
        font-size: 13px;
        color: #3d3a3b;
        margin-top: 6px;
    }

    .sy-letterhead__subtitle {
        font-family: {{ $pdfBodyFont ?? 'cairo' }}, sans-serif;
        font-size: 12px;
        color: #988561;
        margin-top: 8px;
    }

    .sy-pdf-meta {
        font-size: 11px;
        color: #3d3a3b;
        margin-bottom: 12px;
    }

    .sy-pdf-section-title {
        font-family: {{ $pdfHeadingFont ?? 'qomra' }}, {{ $pdfBodyFont ?? 'cairo' }}, sans-serif;
        font-size: 14px;
        font-weight: bold;
        background-color: #ecf4f1;
        padding: 6px 8px;
        margin: 16px 0 6px;
        border-right: 4px solid #b9a779;
        color: #042623;
    }

    .sy-info-table,
    .sy-data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .sy-info-table td {
        padding: 6px 8px;
        border: 1px solid #b9a779;
    }

    .sy-info-table td.sy-label {
        background-color: #f3ede0;
        font-weight: bold;
        width: 28%;
        color: #042623;
    }

    .sy-data-table th,
    .sy-data-table td {
        padding: 6px 8px;
        border: 1px solid #b9a779;
        font-size: 11px;
    }

    .sy-data-table thead tr {
        background-color: #d4e8e2;
        color: #042623;
        font-weight: bold;
    }

    .sy-data-table thead th {
        border-bottom: 2px solid #b9a779;
    }

    .sy-data-table tbody tr.even {
        background-color: #e8f2ef;
    }

    .sy-pdf-empty {
        color: #988561;
        font-size: 11px;
        padding: 6px;
    }

    .sy-pdf-signature {
        margin-top: 40px;
        font-size: 12px;
    }

    .sy-pdf-signature td {
        padding-top: 8px;
    }
</style>
