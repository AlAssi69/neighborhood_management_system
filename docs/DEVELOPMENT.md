# Development / التطوير

**English:** Testing, PDF fonts, and maintainer notes for the Neighborhood Information Management System.  
**العربية:** الاختبارات وخطوط PDF وملاحظات صيانة النظام للمطورين.

## Table of contents / جدول المحتويات

- [Running tests / تشغيل الاختبارات](#running-tests--تشغيل-الاختبارات)
- [Test coverage / تغطية الاختبارات](#test-coverage--تغطية-الاختبارات)
- [Domain enums and migrations / التعدادات والهجرات](#domain-enums-and-migrations--التعدادات-والهجرات)
- [Document storage (technical) / تخزين المستندات (تقني)](#document-storage-technical--تخزين-المستندات-تقني)
- [PDF export fonts / خطوط تصدير PDF](#pdf-export-fonts--خطوط-تصدير-pdf)
- [Regenerating PDF fonts / إعادة توليد خطوط PDF](#regenerating-pdf-fonts--إعادة-توليد-خطوط-pdf)
- [mPDF cache / ذاكرة mPDF المؤقتة](#mpdf-cache--ذاكرة-mpdf-المؤقتة)
- [Frontend theme development / تطوير ثيم الواجهة](#frontend-theme-development--تطوير-ثيم-الواجهة)
- [Design documentation / وثائق التصميم](#design-documentation--وثائق-التصميم)
- [Related docs / وثائق ذات صلة](#related-docs--وثائق-ذات-صلة)

## Running tests / تشغيل الاختبارات

**English:**

```bash
php artisan test
```

Or via Composer:

```bash
composer test
```

Requires a working PHP install and dependencies from `composer install`. Tests use the Laravel testing environment (SQLite in memory or as configured in `phpunit.xml`).

**العربية:**

```bash
php artisan test
```

أو `composer test`. يتطلب تثبيت الاعتماديات عبر Composer.

## Test coverage / تغطية الاختبارات

**English:** Feature tests under `tests/Feature/`:

| Test class | Coverage |
|------------|----------|
| `PanelSmokeTest` | Admin dashboard and CRUD index/create for `people`, `families`, `properties`, `businesses`, `locations`, `real-estate-areas`, `buildings`; edit pages with relation managers; `min_family_members` table filter |
| `PersonPdfTest` | Bundled PDF fonts present; Cairo glyph coverage; RTL person PDF bytes; PDF must not contain income text |
| `DocumentArchivingTest` | Upload to `documents` disk; DB stores path only |
| `ExampleTest` | Laravel application smoke test |

Add tests with `php artisan make:test --phpunit Feature/YourTest`.

**العربية:** `PanelSmokeTest` (كل الموارد بما فيها المباني والمناطق العقارية والفلاتر)، `PersonPdfTest` (خطوط وPDF بدون حقل دخل)، `DocumentArchivingTest`، `ExampleTest`.

## Domain enums and migrations / التعدادات والهجرات

**English:** Person–property **legal status** is defined in `app/Support/PropertyRelationType.php` (`owner`, `tenant`, `vacant`) and used in Filament relation managers and the person PDF template.

If upgrading a database created before June 2026, run pending migrations. Migration `2026_06_03_185220_update_person_property_relation_types` maps legacy `resident` pivot values to `tenant` and sets the default to `tenant`. Migration `2026_06_03_185220_drop_income_from_people_table` removes the unused `income` column from `people`.

**العربية:** الوضع القانوني في `PropertyRelationType` (مالك / مستأجر / فروغ). عند ترقية قاعدة قديمة نفّذ الهجرات؛ `resident` يُحوَّل إلى `tenant` ويُزال عمود `income`.

## Document storage (technical) / تخزين المستندات (تقني)

**English:** `ArchivedDocument` uses the `documents` filesystem disk. Files live under `storage/app/documents/`. The model stores `file_path`, `title`, and document type — never BLOB content in SQLite.

**العربية:** القرص `documents` تحت `storage/app/documents/`. قاعدة البيانات تحفظ المسار والعنوان والنوع فقط.

## PDF export fonts / خطوط تصدير PDF

**English:** Official PDFs share fonts with the admin theme identity:

| Role | Font | Path |
|------|------|------|
| Body / tables | Cairo (Arabic + Latin merged) | `resources/fonts/pdf/cairo/` |
| Letterhead & section titles | itf Qomra Arabic | `resources/fonts/pdf/qomra/` (converted for mPDF) |

Qomra for the **web UI** uses CFF outlines in `public/fonts/qomra/`. **mPDF** requires TrueType `glyf` outlines, so converted files are committed under `resources/fonts/pdf/qomra/`.

Rendering is handled by `app/Services/PdfService.php` using `config/pdf.php` and Blade views in `resources/views/pdf/`.

**العربية:** جسم النص Cairo؛ العناوين Qomra. نسخة الويب في `public/fonts/qomra/`؛ نسخة mPDF محوّلة في `resources/fonts/pdf/qomra/`.

## Regenerating PDF fonts / إعادة توليد خطوط PDF

**English:** Regenerate all PDF fonts (Cairo from fontsource + Qomra conversion):

```bash
npm install @fontsource/cairo --no-save
pip install fonttools brotli
python scripts/setup-pdf-fonts.py
```

Qomra only, after updating `public/fonts/qomra/`:

```bash
pip install fonttools
python scripts/convert-qomra-for-mpdf.py
```

If converted Qomra files are missing, PDF export still works and uses **Cairo Bold** for headings; a warning is written to the application log.

**العربية:** لإعادة توليد كل الخطوط استخدم `scripts/setup-pdf-fonts.py`. لتحويل Qomra فقط: `scripts/convert-qomra-for-mpdf.py`. بدون Qomra يُستخدم Cairo Bold للعناوين.

## mPDF cache / ذاكرة mPDF المؤقتة

**English:** After changing PDF fonts or mPDF OTL settings in `config/pdf.php`, delete the cache directory so mPDF rebuilds font metrics:

```bash
# Unix
rm -rf storage/app/mpdf-temp

# Windows PowerShell
Remove-Item -Recurse -Force storage\app\mpdf-temp
```

**العربية:** بعد تغيير الخطوط أو إعدادات mPDF احذف `storage/app/mpdf-temp` لإعادة بناء ذاكرة الخطوط.

## Frontend theme development / تطوير ثيم الواجهة

**English:**

- Source: `resources/css/filament/admin/` (Tailwind + Syrian tokens)
- Build: `npm run build` → output in `public/build/`
- Live reload: `composer dev` or `npm run dev` alongside `php artisan serve`

Panel registration: `app/Providers/Filament/AdminPanelProvider.php` (`viteTheme('resources/css/filament/admin/theme.css')`).

**العربية:** المصدر في `resources/css/filament/admin/`. البناء بـ `npm run build`. للتطوير الحي: `npm run dev` أو `composer dev`.

## Design documentation / وثائق التصميم

**English:** Brand and UI reference (not required to run the app):

- [design/DESIGN.md](design/DESIGN.md)
- [design/SYRIAN_BRAND_TOKENS.md](design/SYRIAN_BRAND_TOKENS.md)
- [design/DESIGN-dark.md](design/DESIGN-dark.md)

PDF partial styles: `resources/views/pdf/partials/brand-styles.blade.php`.

**العربية:** إرشادات الهوية في `docs/design/`. أنماط PDF في `resources/views/pdf/partials/brand-styles.blade.php`.

## Related docs / وثائق ذات صلة

**English:**

- [INSTALLATION.md](INSTALLATION.md) — first-time setup
- [RUNNING.md](RUNNING.md) — start server and URLs
- [USAGE.md](USAGE.md) — admin workflows
- [../README.md](../README.md) — architecture and data model
- [../SRS_v1.md](../SRS_v1.md) — requirements specification

**العربية:**

- [INSTALLATION.md](INSTALLATION.md) — التثبيت
- [RUNNING.md](RUNNING.md) — التشغيل
- [USAGE.md](USAGE.md) — الاستخدام
- [../README.md](../README.md) — المعمارية ونموذج البيانات
- [../SRS_v1.md](../SRS_v1.md) — مواصفات المتطلبات
