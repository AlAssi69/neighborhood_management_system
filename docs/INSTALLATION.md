# Installation / التثبيت

**English:** Set up the Neighborhood Information Management System on a local machine.  
**العربية:** إعداد نظام إدارة معلومات الحي على جهاز محلي.

## Table of contents / جدول المحتويات

- [Requirements / المتطلبات](#requirements--المتطلبات)
- [Get the code / الحصول على المشروع](#get-the-code--الحصول-على-المشروع)
- [Standard installation / التثبيت القياسي](#standard-installation--التثبيت-القياسي)
- [One-command setup / إعداد بأمر واحد](#one-command-setup--إعداد-بأمر-واحد)
- [Environment configuration / إعداد البيئة](#environment-configuration--إعداد-البيئة)
- [Database and seed data / قاعدة البيانات والبيانات الأولية](#database-and-seed-data--قاعدة-البيانات-والبيانات-الأولية)
- [Frontend assets (optional) / أصول الواجهة (اختياري)](#frontend-assets-optional--أصول-الواجهة-اختياري)
- [Default admin account / حساب المسؤول الافتراضي](#default-admin-account--حساب-المسؤول-الافتراضي)
- [Troubleshooting / استكشاف الأخطاء](#troubleshooting--استكشاف-الأخطاء)
- [Next steps / الخطوات التالية](#next-steps--الخطوات-التالية)

## Requirements / المتطلبات

**English:**

| Requirement | Version / notes |
|-------------|-----------------|
| PHP | 8.3 or newer (8.4 recommended); extensions: `mbstring`, `openssl`, `pdo_sqlite`, `fileinfo`, `intl` (recommended for Arabic) |
| Composer | 2.x |
| Node.js | 18+ — only if rebuilding Filament/Vite assets (`npm run build`) |
| Python 3 | Optional — only for regenerating PDF fonts ([DEVELOPMENT.md](DEVELOPMENT.md)) |

No MySQL/PostgreSQL server is required; the default database is SQLite.

**العربية:**

| المتطلب | الإصدار / ملاحظات |
|---------|-------------------|
| PHP | 8.3 أو أحدث (يُفضّل 8.4); الامتدادات: `mbstring`, `openssl`, `pdo_sqlite`, `fileinfo`, `intl` |
| Composer | 2.x |
| Node.js | 18+ — فقط عند إعادة بناء أصول Vite |
| Python 3 | اختياري — لإعادة توليد خطوط PDF |

لا حاجة لخادم MySQL؛ الافتراضي SQLite.

## Get the code / الحصول على المشروع

**English:** Clone or copy the repository to a directory on the machine that will run the app (e.g. `D:\Projects\NeighborhoodManagment`).

**العربية:** انسخ المستودع أو استنسخه إلى مجلد على الجهاز الذي سيشغّل التطبيق.

## Standard installation / التثبيت القياسي

**English:** From the project root:

```bash
composer install
```

Create the environment file if it does not exist:

```bash
# Windows (Command Prompt or PowerShell)
copy .env.example .env

# macOS / Linux
cp .env.example .env
```

Generate the application key and run migrations with seed data:

```bash
php artisan key:generate
php artisan migrate --seed
```

`migrate --seed` creates all tables, the default admin user, and sample Arabic neighborhood data (`NeighborhoodSeeder`).

**العربية:** من جذر المشروع نفّذ `composer install`، ثم انسخ `.env.example` إلى `.env`، ثم `php artisan key:generate` و `php artisan migrate --seed`. الأمر الأخير ينشئ الجداول وحساب المسؤول وبيانات عينة عربية.

## One-command setup / إعداد بأمر واحد

**English:** Composer defines a `setup` script that installs PHP dependencies, ensures `.env` exists, generates the key, runs migrations, installs npm packages, and builds frontend assets:

```bash
composer setup
```

Use this on a machine with **Node.js and npm** available. If you are fully offline and `public/build/` already exists in the copy you received, you can skip npm and use the [standard installation](#standard-installation--التثبيت-القياسي) without `composer setup`.

**العربية:** `composer setup` يثبّت الاعتماديات ويولّد المفتاح ويهاجر قاعدة البيانات ويبني أصول npm. على جهاز دون Node، استخدم التثبيت القياسي إذا كان مجلد `public/build/` موجوداً مسبقاً.

## Environment configuration / إعداد البيئة

**English:** Key variables in `.env` (defaults from `.env.example`):

| Variable | Default | Purpose |
|----------|---------|---------|
| `APP_NAME` | Laravel | Shown in PDF letterhead (`config('app.name')`) |
| `APP_URL` | `http://localhost` | Base URL; set to your LAN URL when accessing from other PCs |
| `DB_CONNECTION` | `sqlite` | File database — no DB server |
| `FILESYSTEM_DISK` | `local` | Local disks including `documents` |

Ensure the SQLite file exists:

```bash
# If database/database.sqlite is missing (Unix)
touch database/database.sqlite

# Windows PowerShell
New-Item -ItemType File -Path database\database.sqlite -Force
```

**العربية:** عدّل `APP_NAME` و`APP_URL` حسب الحاجة. الاتصال الافتراضي `sqlite`. تأكد من وجود ملف `database/database.sqlite` قبل الهجرة.

## Database and seed data / قاعدة البيانات والبيانات الأولية

**English:**

- Schema: `database/migrations/`
- Seeders: `database/seeders/DatabaseSeeder.php` (admin user) and `NeighborhoodSeeder.php` (sample data)

To reset and reseed (destroys data):

```bash
php artisan migrate:fresh --seed
```

**العربية:** الهجرات في `database/migrations/`. لإعادة تهيئة قاعدة البيانات مع البذور: `php artisan migrate:fresh --seed` (يحذف البيانات الحالية).

## Frontend assets (optional) / أصول الواجهة (اختياري)

**English:** The Filament admin theme is built with Vite. Prebuilt files are committed under `public/build/`, so **npm is not required** for a normal install.

Rebuild only after changing `resources/css/filament/admin/`:

```bash
npm install
npm run build
```

**العربية:** ملفات `public/build/` مضمّنة في المشروع. أعد البناء بـ `npm run build` فقط بعد تعديل ملفات CSS للوحة الإدارة.

## Default admin account / حساب المسؤول الافتراضي

**English:** Created by `DatabaseSeeder`:

| Field | Value |
|-------|-------|
| Email | `admin@local.test` |
| Password | `password` |

Change the password immediately after first login (Filament user menu).

**العربية:** البريد `admin@local.test` وكلمة المرور `password`. غيّر كلمة المرور فور أول دخول.

## Troubleshooting / استكشاف الأخطاء

**English:**

| Problem | Solution |
|---------|----------|
| `could not find driver` (SQLite) | Enable `pdo_sqlite` in `php.ini` |
| Permission denied on `storage/` or `bootstrap/cache/` | Make directories writable by the web/PHP user |
| `No application encryption key` | Run `php artisan key:generate` |
| Blank or unstyled admin UI | Run `npm run build` or ensure `public/build/manifest.json` exists |
| Migration fails on fresh clone | Create `database/database.sqlite` then retry `php artisan migrate` |

`php artisan storage:link` is only needed if you serve public disk files via `/storage`; document uploads use the private `documents` disk under `storage/app/documents/`.

**العربية:**

| المشكلة | الحل |
|---------|------|
| خطأ SQLite driver | فعّل `pdo_sqlite` |
| صلاحيات `storage/` | امنح الكتابة لمجلدات التخزين والكاش |
| مفتاح التشفير | `php artisan key:generate` |
| واجهة بلا تنسيق | تحقق من `public/build/` أو نفّذ `npm run build` |

## Next steps / الخطوات التالية

**English:** Continue with [RUNNING.md](RUNNING.md) to start the server and open the admin panel, then [USAGE.md](USAGE.md) for day-to-day operation.

**العربية:** تابع مع [RUNNING.md](RUNNING.md) ثم [USAGE.md](USAGE.md).
