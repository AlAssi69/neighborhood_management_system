# Documentation / الوثائق

**English:** Guides for installing, running, and using the Neighborhood Information Management System, plus developer notes.  
**العربية:** أدلة تثبيت وتشغيل واستخدام نظام إدارة معلومات الحي، مع ملاحظات للمطورين.

## Table of contents / جدول المحتويات

- [Who should read what / لمن كل دليل](#who-should-read-what--لمن-كل-دليل)
- [Guides / الأدلة](#guides--الأدلة)
- [Design assets / أصول التصميم](#design-assets--أصول-التصميم)
- [Project root / جذر المشروع](#project-root--جذر-المشروع)

## Who should read what / لمن كل دليل

**English:**

| Role | Start here |
|------|------------|
| **Installer / IT** | [INSTALLATION.md](INSTALLATION.md) → [RUNNING.md](RUNNING.md) |
| **Neighborhood administrator** | [RUNNING.md](RUNNING.md) (login URL) → [USAGE.md](USAGE.md) |
| **Developer / maintainer** | [DEVELOPMENT.md](DEVELOPMENT.md) + [../README.md](../README.md) (structure & data model) |
| **Designer** | [design/DESIGN.md](design/DESIGN.md), [design/SYRIAN_BRAND_TOKENS.md](design/SYRIAN_BRAND_TOKENS.md) |

**العربية:**

| الدور | ابدأ من |
|-------|---------|
| **مسؤول التثبيت / تقنية المعلومات** | [INSTALLATION.md](INSTALLATION.md) ثم [RUNNING.md](RUNNING.md) |
| **مسؤول الحي (المستخدم)** | [RUNNING.md](RUNNING.md) ثم [USAGE.md](USAGE.md) |
| **المطور / الصيانة** | [DEVELOPMENT.md](DEVELOPMENT.md) و [../README.md](../README.md) |
| **المصمم** | [design/DESIGN.md](design/DESIGN.md) |

## Guides / الأدلة

| Document | Description (EN) | الوصف (AR) |
|----------|------------------|------------|
| [INSTALLATION.md](INSTALLATION.md) | Prerequisites, Composer, `.env`, SQLite, migrate/seed, npm, troubleshooting | المتطلبات، Composer، SQLite، البذور، استكشاف الأخطاء |
| [RUNNING.md](RUNNING.md) | `php artisan serve`, admin URL, `composer dev`, offline deployment | التشغيل المحلي، الرابط، النشر دون إنترنت |
| [USAGE.md](USAGE.md) | Admin panel: navigation, workflows, search, PDF, CSV, documents | لوحة الإدارة: التنقل، سير العمل، PDF، CSV |
| [DEVELOPMENT.md](DEVELOPMENT.md) | Tests, PDF fonts, mPDF cache, design doc links | الاختبارات، خطوط PDF، ذاكرة mPDF |

## Design assets / أصول التصميم

**English:** Brand guidelines and reference CSS live under `docs/design/`. They are not required to run the app but document the Syrian visual identity used in Filament and PDFs.

**العربية:** إرشادات الهوية البصرية وملفات CSS المرجعية في `docs/design/`. ليست مطلوبة للتشغيل لكنها توثّق هوية الواجهة وملفات PDF.

- [design/DESIGN.md](design/DESIGN.md)
- [design/SYRIAN_BRAND_TOKENS.md](design/SYRIAN_BRAND_TOKENS.md)
- [design/DESIGN-dark.md](design/DESIGN-dark.md)

## Project root / جذر المشروع

**English:** Return to the main [README.md](../README.md) for project overview, stack summary, directory tree, and entity relationship diagram.

**العربية:** ارجع إلى [README.md](../README.md) للنظرة العامة والهيكل ومخطط العلاقات بين الكيانات.
