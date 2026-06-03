# نظام إدارة معلومات الحي — Neighborhood Information Management System

An offline, single-admin web application for managing neighborhood data: persons,
families, properties (real estate), businesses, hierarchical addresses, document
archiving, search/filtering, a statistics dashboard, and official Arabic RTL PDF export.

## Stack

- PHP 8.4 + Laravel 13
- Filament v5 admin panel (single-admin auth, CRUD, dashboard, filters)
- SQLite local database (file-based, no server, fully offline)
- mPDF for Arabic/RTL print-ready PDFs (no internet / headless browser needed)
- Local filesystem disk for archived documents (only file paths stored in DB)

Everything runs locally with no internet connection required at runtime. All assets
(JS/CSS) are published locally. The admin panel uses **itf Qomra Arabic** (headings)
and **Cairo** (body), matching exported PDFs.

## Requirements

- PHP 8.4+
- Composer 2.x

## Setup

```bash
composer install
copy .env.example .env   # if .env is missing (Windows); use cp on macOS/Linux
php artisan key:generate
php artisan migrate --seed
```

`migrate --seed` creates the schema, an admin account, and sample Arabic data.

## Running

```bash
php artisan serve
```

Then open `http://127.0.0.1:8000/admin`.

Default admin credentials (change the password after first login):

- Email: `admin@local.test`
- Password: `password`

## Architecture overview

- `app/Models` — Eloquent models and relationships:
  - `Person` (national_id, names, phone, income) belongs to a `Family`, has many
    `properties` (pivot `person_property` with `relation_type` = resident/owner),
    `businesses`, and `documents`.
  - `Family` (family_card_number) has many members and a head person.
  - `Property` (property_number) belongs to a `Location`, has residents and businesses.
  - `Location` self-references via `parent_id` for infinite area nesting.
  - `Business` (commercial_register_number) belongs to a property and an owner.
  - `ArchivedDocument` stores `file_path` on the `documents` disk (no BLOBs).
- `app/Filament/Resources` — CRUD resources, cascading location dropdowns, filters.
- `app/Filament/Resources/People/RelationManagers` — link persons to properties,
  businesses, and documents.
- `app/Filament/Widgets` + `app/Filament/Pages/Dashboard.php` — statistics overview,
  income-by-area chart, and CSV export of raw statistics.
- `app/Services/PdfService.php` — decoupled mPDF renderer (HTML/Blade -> PDF bytes).
- `resources/views/pdf/person-form.blade.php` — official RTL Arabic form template.
- `resources/views/pdf/partials/brand-styles.blade.php` — Syrian brand tokens and `.sy-*` PDF styles.

## PDF export fonts

Official PDFs use the same visual identity as the Filament admin theme:

| Role | Font | Path |
|------|------|------|
| Body / tables | Cairo (arabic + latin merged) | `resources/fonts/pdf/cairo/` |
| Letterhead & section titles | itf Qomra Arabic | `resources/fonts/pdf/qomra/` (converted for mPDF) |

Qomra ships as CFF outlines in `public/fonts/qomra/` (web UI). mPDF requires TrueType
`glyf` outlines, so converted files are committed under `resources/fonts/pdf/qomra/`.

To regenerate all PDF fonts (Cairo from fontsource + Qomra conversion):

```bash
npm install @fontsource/cairo --no-save
pip install fonttools brotli
python scripts/setup-pdf-fonts.py
```

Or only Qomra after updating `public/fonts/qomra/`:

```bash
pip install fonttools
python scripts/convert-qomra-for-mpdf.py
```

If converted Qomra files are missing, PDF export still works and uses **Cairo Bold** for
headings (a warning is written to the log).

After changing PDF fonts or mPDF OTL settings, delete `storage/app/mpdf-temp` so mPDF
regenerates font metrics caches.

## Document storage

Uploaded documents are stored under `storage/app/documents`. The database only keeps
the relative file path, document type, and title — never the raw binary.

## Tests

```bash
php artisan test
```

Feature tests cover panel rendering, compound filters, document upload (path-only
storage), and Arabic PDF generation.
