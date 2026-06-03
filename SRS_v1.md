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

* **Person:** National ID (Primary Key), First Name, Father's Name, Last Name, Phone Number, Income Data.
* **Family:** Family Card Number (Primary Key), Head of Household ID, Total Member Count.
* **Property (Real Estate):** Property Number, Real Estate Area, Main Area, Detailed Address, Floor Number.
* **Address Hierarchy:** Location ID, Location Name, Parent Location ID (allowing for infinite nesting of areas).
* **Business (Commercial Register):** Commercial Register Number, Business Name, Associated Property.
* **Archived Document:** Document ID, Person ID, File Path, Document Type, Upload Timestamp.

---

## 4. Functional Requirements (System Modules)

### 4.1. Entity Management Module (CRUD)

* Provide robust interfaces to Create, Read, Update, and Delete records for Persons, Families, Properties, and Businesses.
* Validate National ID formats and alert users to duplicate entries.
* Manage hierarchical address data efficiently through dynamic dropdowns (e.g., selecting a Main Area populates the Sub-Area options).

### 4.2. Relationship Mapping Module

* Link individuals to a distinct Family unit using the Family Card Number.
* Associate a Person with one or more Properties to define residence or ownership status.
* Connect a Person to specific Businesses via the Commercial Register.
* Maintain referential integrity when entities are deleted (e.g., unlinking a person from a property if the property record is removed).

### 4.3. Search and Filtering Engine

* Execute exact and partial text searches on names, IDs, and phone numbers.
* Filter resident populations by specific geographic areas, real estate zones, or property numbers.
* Apply compound filters, such as searching for families with more than five members within a specific income bracket.

### 4.4. Dashboard and Statistical Reporting

* Aggregate real-time neighborhood data to display total population, family count, and active businesses.
* Generate income-based statistics grouped by geographic area or real estate zone.
* Export raw statistical data for external reporting.

### 4.5. Document Archiving and PDF Export

* Upload and securely link scanned documents (images/PDFs) directly to specific Person profiles.
* Populate predefined official government web templates dynamically using system data.
* Export these populated HTML views as formatted, print-ready PDF files for official use.

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