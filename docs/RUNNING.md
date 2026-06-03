# Running the application / تشغيل التطبيق

**English:** Start the web server and access the admin panel locally or on a LAN.  
**العربية:** تشغيل خادم الويب والوصول إلى لوحة الإدارة محلياً أو على الشبكة المحلية.

## Table of contents / جدول المحتويات

- [Development server / خادم التطوير](#development-server--خادم-التطوير)
- [Admin panel URL / رابط لوحة الإدارة](#admin-panel-url--رابط-لوحة-الإدارة)
- [Login credentials / بيانات الدخول](#login-credentials--بيانات-الدخول)
- [Full development stack / بيئة التطوير الكاملة](#full-development-stack--بيئة-التطوير-الكاملة)
- [Production and offline use / الإنتاج والاستخدام دون إنترنت](#production-and-offline-use--الإنتاج-والاستخدام-دون-إنترنت)
- [Backups / النسخ الاحتياطي](#backups--النسخ-الاحتياطي)
- [Next steps / الخطوات التالية](#next-steps--الخطوات-التالية)

## Development server / خادم التطوير

**English:** From the project root:

```bash
php artisan serve
```

By default the app listens on `http://127.0.0.1:8000`. To bind all interfaces (e.g. access from another PC on the LAN):

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Set `APP_URL` in `.env` to match how clients reach the server (e.g. `http://192.168.1.10:8000`).

**العربية:** من جذر المشروع: `php artisan serve`. للوصول من أجهزة أخرى على الشبكة: `--host=0.0.0.0` وعدّل `APP_URL` في `.env`.

## Admin panel URL / رابط لوحة الإدارة

**English:** The Filament panel is mounted at path `/admin` (see `app/Providers/Filament/AdminPanelProvider.php`).

| Server | Admin URL |
|--------|-----------|
| Default `artisan serve` | http://127.0.0.1:8000/admin |
| Custom host/port | `http://<host>:<port>/admin` |

The UI is **Arabic RTL**. No separate public front-end is provided; all data entry is through this panel.

**العربية:** لوحة الإدارة على المسار `/admin`. الواجهة عربية RTL. لا واجهة عامة منفصلة — كل الإدخال عبر هذه اللوحة.

## Login credentials / بيانات الدخول

**English:** After [installation](INSTALLATION.md) with `--seed`:

| Field | Value |
|-------|-------|
| Email | `admin@local.test` |
| Password | `password` |

There is a **single admin** account model (`App\Models\User`). Change the password after first login.

**العربية:** بعد التثبيت مع `--seed` استخدم البريد وكلمة المرور أعلاه. حساب مسؤول واحد — غيّر كلمة المرور بعد أول دخول.

## Full development stack / بيئة التطوير الكاملة

**English:** For theme/CSS work, `composer.json` provides a combined dev command:

```bash
composer dev
```

This runs concurrently:

- `php artisan serve` — web server
- `php artisan queue:listen` — queue worker
- `php artisan pail` — log tail
- `npm run dev` — Vite HMR for Filament theme

**Normal neighborhood administration does not require a queue.** CRUD, uploads, and PDF export run synchronously. Use `php artisan serve` alone unless you are developing assets or debugging queues.

**العربية:** `composer dev` يشغّل الخادم والطابور والسجلات وVite معاً. للاستخدام اليومي يكفي `php artisan serve` — الطابور غير مطلوب للعمليات العادية.

## Production and offline use / الإنتاج والاستخدام دون إنترنت

**English:**

- The app is designed to run **fully offline** at runtime: SQLite file DB, local JS/CSS/fonts, mPDF for PDFs (no headless Chrome, no CDN).
- Deploy on a dedicated PC or LAN server with PHP 8.3+ and Composer (install once; runtime needs only PHP).
- Set `APP_ENV=production`, `APP_DEBUG=false`, and a strong admin password.
- Use a process manager or Windows service to keep `php artisan serve` or `php-fpm` + nginx running if needed.
- Do not expose the panel to the public internet without HTTPS and hardening; intended for trusted local/LAN use.

**العربية:** التطبيق يعمل دون إنترنت: SQLite وملفات محلية وmPDF. ثبّت على جهاز أو خادم شبكة محلية. عيّن `APP_ENV=production` وكلمة مرور قوية. لا تعرّض اللوحة للإنترنت العام دون تأمين مناسب.

## Backups / النسخ الاحتياطي

**English:** Back up regularly:

| Path | Contents |
|------|----------|
| `database/database.sqlite` | All structured data |
| `storage/app/documents/` | Uploaded archived files |

Copy both to external media. Restoring: replace files while the app is stopped, then restart.

**العربية:** انسخ احتياطياً `database/database.sqlite` و `storage/app/documents/` معاً. استبدلهما والتطبيق متوقف عند الاستعادة.

## Next steps / الخطوات التالية

**English:** See [USAGE.md](USAGE.md) for how to enter data, export PDFs, and use the dashboard.

**العربية:** راجع [USAGE.md](USAGE.md) لسير العمل اليومي في لوحة الإدارة.
