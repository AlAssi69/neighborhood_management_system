<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    @include('pdf.partials.brand-styles')
</head>
<body>
    <div class="sy-letterhead sy-letterhead--top">
        <img src="{{ public_path('images/brand/syrian-horizontal-dark-green.svg') }}" alt="">
        <p class="sy-letterhead__line sy-letterhead__line--republic">الجمهورية العربية السورية</p>
        <p class="sy-letterhead__line sy-letterhead__line--ministry">نظام إدارة معلومات الحي</p>
        <p class="sy-letterhead__line sy-letterhead__line--directorate">{{ $neighborhoodName }}</p>
        <p class="sy-letterhead__subtitle">نموذج بيانات رسمي للمواطن</p>
    </div>

    <div class="sy-pdf-meta">
        تاريخ الإصدار: {{ $issuedAt }} &nbsp;|&nbsp; رقم المرجع: {{ $person->national_id }}
    </div>

    <h2 class="sy-pdf-section-title">المعلومات الشخصية</h2>
    <table class="sy-info-table">
        <tr>
            <td class="sy-label">الاسم الكامل</td>
            <td>{{ $person->full_name }}</td>
        </tr>
        <tr>
            <td class="sy-label">الرقم الوطني</td>
            <td>{{ $person->national_id }}</td>
        </tr>
        <tr>
            <td class="sy-label">رقم الهاتف</td>
            <td>{{ $person->phone ?: '—' }}</td>
        </tr>
    </table>

    <h2 class="sy-pdf-section-title">البيانات العائلية</h2>
    <table class="sy-info-table">
        <tr>
            <td class="sy-label">رقم بطاقة العائلة</td>
            <td>{{ $person->family?->family_card_number ?: '—' }}</td>
        </tr>
        <tr>
            <td class="sy-label">عدد أفراد العائلة</td>
            <td>{{ $person->family?->total_member_count ?? '—' }}</td>
        </tr>
        <tr>
            <td class="sy-label">رب الأسرة</td>
            <td>{{ $person->family?->head?->full_name ?: '—' }}</td>
        </tr>
    </table>

    <h2 class="sy-pdf-section-title">العقارات والسكن</h2>
    @if ($person->properties->isNotEmpty())
        <table class="sy-data-table">
            <thead>
                <tr>
                    <th>رقم العقار</th>
                    <th>المنطقة العقارية</th>
                    <th>عنوان السكن</th>
                    <th>الوضع القانوني</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($person->properties as $property)
                    <tr @class(['even' => $loop->even])>
                        <td>{{ $property->property_number }}</td>
                        <td>{{ $property->realEstateArea?->name ?: '—' }}</td>
                        <td>{{ $property->full_residential_address ?: '—' }}</td>
                        <td>{{ \App\Support\PropertyRelationType::labelFor($property->pivot->relation_type) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="sy-pdf-empty">لا توجد عقارات مرتبطة.</div>
    @endif

    <h2 class="sy-pdf-section-title">المحال التجارية</h2>
    @if ($person->businesses->isNotEmpty())
        <table class="sy-data-table">
            <thead>
                <tr>
                    <th>رقم السجل التجاري</th>
                    <th>اسم المحل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($person->businesses as $business)
                    <tr @class(['even' => $loop->even])>
                        <td>{{ $business->commercial_register_number }}</td>
                        <td>{{ $business->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="sy-pdf-empty">لا توجد محال تجارية مرتبطة.</div>
    @endif

    <table class="sy-pdf-signature" width="100%">
        <tr>
            <td width="50%">توقيع المسؤول: ................................</td>
            <td width="50%">الختم الرسمي: ................................</td>
        </tr>
    </table>
</body>
</html>
