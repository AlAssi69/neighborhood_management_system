<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: dejavusans, sans-serif;
            direction: rtl;
            text-align: right;
            color: #161616;
            font-size: 12px;
        }
        .letterhead {
            text-align: center;
            border-bottom: 2px solid #b9a779;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }
        .letterhead img {
            max-width: 320px;
            height: auto;
            margin-bottom: 8px;
        }
        .letterhead .line-republic {
            font-family: dejavusans, sans-serif;
            font-weight: bold;
            font-size: 18px;
            color: #042623;
            margin: 4px 0;
        }
        .letterhead .line-ministry {
            font-family: dejavusans, sans-serif;
            font-size: 14px;
            color: #042623;
            margin: 2px 0;
        }
        .letterhead .line-neighborhood {
            font-size: 13px;
            color: #3d3a3b;
            margin-top: 6px;
        }
        .letterhead .subtitle {
            font-size: 12px;
            color: #988561;
            margin-top: 8px;
        }
        .meta {
            font-size: 11px;
            color: #3d3a3b;
            margin-bottom: 12px;
        }
        h2 {
            font-family: dejavusans, sans-serif;
            font-size: 14px;
            font-weight: bold;
            background: #ecf4f1;
            padding: 6px 8px;
            margin: 16px 0 6px;
            border-right: 4px solid #b9a779;
            color: #042623;
        }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        table.info td { padding: 6px 8px; border: 1px solid rgba(185, 167, 121, 0.35); }
        table.info td.label {
            background: #f3ede0;
            font-weight: bold;
            width: 28%;
            color: #042623;
        }
        table.grid th, table.grid td {
            padding: 6px 8px;
            border: 1px solid rgba(185, 167, 121, 0.35);
            font-size: 11px;
        }
        table.grid th {
            background: #d4e8e2;
            color: #042623;
            border-bottom: 2px solid #b9a779;
        }
        table.grid tbody tr:nth-child(even) {
            background: #e8f2ef;
        }
        .empty { color: #988561; font-size: 11px; padding: 6px; }
        .signature { margin-top: 40px; font-size: 12px; }
        .signature .box { display: inline-block; width: 45%; }
    </style>
</head>
<body>
    <div class="letterhead">
        <img src="{{ public_path('images/brand/syrian-horizontal-dark-green.svg') }}" alt="">
        <p class="line-republic">الجمهورية العربية السورية</p>
        <p class="line-ministry">نظام إدارة معلومات الحي</p>
        <p class="line-neighborhood">{{ $neighborhoodName }}</p>
        <p class="subtitle">نموذج بيانات رسمي للمواطن</p>
    </div>

    <div class="meta">
        تاريخ الإصدار: {{ $issuedAt }} &nbsp;|&nbsp; رقم المرجع: {{ $person->national_id }}
    </div>

    <h2>المعلومات الشخصية</h2>
    <table class="info">
        <tr>
            <td class="label">الاسم الكامل</td>
            <td>{{ $person->full_name }}</td>
        </tr>
        <tr>
            <td class="label">الرقم الوطني</td>
            <td>{{ $person->national_id }}</td>
        </tr>
        <tr>
            <td class="label">رقم الهاتف</td>
            <td>{{ $person->phone ?: '—' }}</td>
        </tr>
        <tr>
            <td class="label">الدخل</td>
            <td>{{ $person->income !== null ? number_format((float) $person->income, 2) . ' ₪' : '—' }}</td>
        </tr>
    </table>

    <h2>البيانات العائلية</h2>
    <table class="info">
        <tr>
            <td class="label">رقم بطاقة العائلة</td>
            <td>{{ $person->family?->family_card_number ?: '—' }}</td>
        </tr>
        <tr>
            <td class="label">عدد أفراد العائلة</td>
            <td>{{ $person->family?->total_member_count ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">رب الأسرة</td>
            <td>{{ $person->family?->head?->full_name ?: '—' }}</td>
        </tr>
    </table>

    <h2>العقارات والسكن</h2>
    @if ($person->properties->isNotEmpty())
        <table class="grid">
            <thead>
                <tr>
                    <th>رقم العقار</th>
                    <th>المنطقة العقارية</th>
                    <th>الموقع</th>
                    <th>الطابق</th>
                    <th>نوع العلاقة</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($person->properties as $property)
                    <tr>
                        <td>{{ $property->property_number }}</td>
                        <td>{{ $property->real_estate_area ?: '—' }}</td>
                        <td>{{ $property->location?->full_path ?: '—' }}</td>
                        <td>{{ $property->floor_number ?? '—' }}</td>
                        <td>{{ $property->pivot->relation_type === 'owner' ? 'مالك' : 'ساكن' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">لا توجد عقارات مرتبطة.</div>
    @endif

    <h2>المحال التجارية</h2>
    @if ($person->businesses->isNotEmpty())
        <table class="grid">
            <thead>
                <tr>
                    <th>رقم السجل التجاري</th>
                    <th>اسم المحل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($person->businesses as $business)
                    <tr>
                        <td>{{ $business->commercial_register_number }}</td>
                        <td>{{ $business->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">لا توجد محال تجارية مرتبطة.</div>
    @endif

    <div class="signature">
        <div class="box">توقيع المسؤول: ................................</div>
        <div class="box">الختم الرسمي: ................................</div>
    </div>
</body>
</html>
