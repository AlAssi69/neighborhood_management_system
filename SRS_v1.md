# Software Requirements Specification (SRS): Neighborhood Information Management System

## 1. Introduction

**Purpose:** This document defines the requirements for a locally hosted or desktop-based application designed to manage neighborhood demographic, real estate, and commercial data.
**Scope:** The system empowers local administrators to input, structure, and analyze data regarding residents, families, properties, and businesses. It features robust relationship mapping, document archiving, automated PDF generation for official forms, and a fully Right-to-Left (RTL) Arabic interface.

---

## 2. Overall Description

**Product Perspective:** A standalone application utilizing a local SQLite database, ensuring complete data privacy, offline accessibility, and fast read/write speeds.
**User Characteristics:** Administrative personnel requiring an intuitive, localized interface for daily data entry and retrieval.
**Operating Environment:** Local desktop environment (Windows/macOS/Linux) or a locally served intranet application.
**Design Constraints:** The architecture must strictly adhere to modular design principles (e.g., SOLID), ensuring separation of concerns between the SQLite database operations, business logic, and the UI presentation layer.

---

## 3. Data Dictionary & Core Entities

* **Person:** National ID (unique), First Name, Father's Name, Last Name, Phone Number, optional Family ID. No income field.
* **Family:** Family Card Number (unique), optional Head of Household (Person ID), Total Member Count, optional notes.
* **Location (residential hierarchy):** Name, optional Parent Location ID (infinite nesting for منطقة السكن).
* **Building:** Location ID, Building Number (per location).
* **Floor:** Building ID, Label, optional sort order.
* **RealEstateArea:** Name (lookup for property registry and statistics — المنطقة العقارية).
* **Property:** Property Number, Real Estate Area ID, Location ID (residential area), Building ID, Floor ID, Detailed Address. Computed full residential address combines location path, building, floor, and detail.
* **Person–Property (pivot `person_property`):** Person ID, Property ID, `relation_type` enum: `owner`, `tenant`, or `vacant` (فروغ / مالك / مستأجر).
* **Business:** Commercial Register Number, Business Name, Property ID, Owner Person ID.
* **Archived Document:** Person ID, File Path (filesystem), Title, Document Type, timestamps.

---

## 4. Functional Requirements (System Modules)

### 4.1. Entity Management Module (CRUD)

* Provide robust interfaces to Create, Read, Update, and Delete records for Persons, Families, Properties, Businesses, Locations, Buildings, Floors, and Real Estate Areas.
* Validate National ID format (numeric, 5–20 digits) and reject duplicate national IDs.
* Manage hierarchical location data and cascading Building/Floor selects on property forms.

### 4.2. Relationship Mapping Module

* Link individuals to a distinct Family unit using the Family Card Number.
* Associate a Person with one or more Properties with legal status: owner, tenant, or vacant (فروغ).
* Connect a Person to specific Businesses via the Commercial Register.
* Maintain referential integrity when entities are deleted (e.g., unlinking a person from a property if the property record is removed).

### 4.3. Search and Filtering Engine

* Execute exact and partial text searches on names, IDs, and phone numbers.
* Filter resident populations by specific geographic areas, real estate zones, or property numbers.
* Apply compound filters on the people list, including: family, geographic area (location subtree), real-estate area, property number, and minimum family member count (`total_member_count` on the linked family).

### 4.4. Dashboard and Statistical Reporting

* Display dashboard widgets for: total registered people, family count, business count, and property count.
* Export a UTF-8 CSV (with BOM for Excel) of population counts grouped by real-estate area, with columns **المنطقة العقارية** and **عدد السكان**. Persons linked to multiple areas are counted in each area; persons without a linked property area count under **غير محدد**. Filename pattern: `neighborhood-stats-YYYYMMDD-HHMMSS.csv`.

### 4.5. Document Archiving and PDF Export

* Upload and securely link scanned documents (images/PDFs) directly to specific Person profiles.
* Populate predefined official government web templates dynamically using system data.
* Export these populated HTML views as formatted, print-ready PDF files for official use. The person PDF includes personal data, family data, linked properties (with legal status), and businesses — not income.

---

## 5. Non-Functional Requirements

### 5.1. User Interface (UI)

* The interface must be strictly Right-to-Left (RTL) natively optimized for the Arabic language.
* Typography, tables, and form layouts must correctly support Arabic script without clipping or misalignment.

### 5.2. Performance and Storage

* Database queries must execute rapidly, maintaining high performance even as the dataset scales.
* Document archives must be stored on the local file system with file paths saved in SQLite, rather than storing raw binary data (BLOBs) in the database, to prevent database bloat.

### 5.3. Modularity & Maintainability

* The system must utilize a layered architecture, abstracting repetitive database queries to keep the codebase DRY (Don't Repeat Yourself).
* The PDF generation logic must be completely decoupled from the core data-entry components.

---

## 6. Documentation and Implementation

**Implementation stack (as built):** PHP 8.3+, Laravel 13, Filament v5.6 (single-admin panel at `/admin`), SQLite, mPDF 8.x for Arabic RTL PDFs, Vite + Tailwind for the admin theme.

**Documentation map:**

| Document | Role |
|----------|------|
| [req.txt](req.txt) | Original Arabic requirements brief |
| [README.md](README.md) | Project overview, stack, structure, entity diagram |
| [docs/README.md](docs/README.md) | Index of install/run/usage/developer guides |
| [docs/INSTALLATION.md](docs/INSTALLATION.md) | Setup and troubleshooting |
| [docs/RUNNING.md](docs/RUNNING.md) | Server, admin URL, backups |
| [docs/USAGE.md](docs/USAGE.md) | Administrator workflows (authoritative for UI behavior) |
| [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) | Tests, PDF fonts, migrations |

This SRS is the requirements baseline. For day-to-day operation and current UI labels, prefer [docs/USAGE.md](docs/USAGE.md) when the two differ.

---