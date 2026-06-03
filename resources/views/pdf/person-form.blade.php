<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; direction: rtl; text-align: right; color: #1f2937; }
        .header { text-align: center; border-bottom: 2px solid #b45309; padding-bottom: 8px; margin-bottom: 14px; }
        .header h1 { margin: 0; font-size: 18px; color: #b45309; }
        .header .subtitle { font-size: 12px; color: #6b7280; margin-top: 4px; }
        .meta { font-size: 11px; color: #6b7280; margin-bottom: 12px; }
        h2 { font-size: 14px; background: #fef3c7; padding: 6px 8px; margin: 16px 0 6px; border-right: 4px solid #f59e0b; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        table.info td { padding: 6px 8px; border: 1px solid #e5e7eb; }
        table.info td.label { background: #f9fafb; font-weight: bold; width: 28%; }
        table.grid th, table.grid td { padding: 6px 8px; border: 1px solid #e5e7eb; font-size: 11px; }
        table.grid th { background: #f3f4f6; }
        .empty { color: #9ca3af; font-size: 11px; padding: 6px; }
        .signature { margin-top: 40px; font-size: 12px; }
        .signature .box { display: inline-block; width: 45%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $neighborhoodName }}</h1>
        <div class="subtitle">نموذج بيانات رسمي للمواطن</div>
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
