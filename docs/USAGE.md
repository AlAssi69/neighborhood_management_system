# Usage guide / دليل الاستخدام

**English:** How to use the Filament admin panel for neighborhood data management.  
**العربية:** كيفية استخدام لوحة إدارة Filament لإدارة بيانات الحي.

## Table of contents / جدول المحتويات

- [Access and language / الدخول واللغة](#access-and-language--الدخول-واللغة)
- [Navigation / التنقل](#navigation--التنقل)
- [Recommended workflow / سير العمل الموصى به](#recommended-workflow--سير-العمل-الموصى-به)
- [Locations / المناطق](#locations--المناطق)
- [Families and people / العائلات والأشخاص](#families-and-people--العائلات-والأشخاص)
- [Properties and businesses / العقارات والمحال](#properties-and-businesses--العقارات-والمحال)
- [Linking a person / ربط الشخص](#linking-a-person--ربط-الشخص)
- [Search and filters / البحث والفلاتر](#search-and-filters--البحث-والفلاتر)
- [Dashboard and CSV export / لوحة المعلومات وتصدير CSV](#dashboard-and-csv-export--لوحة-المعلومات-وتصدير-csv)
- [Official PDF export / تصدير النموذج الرسمي PDF](#official-pdf-export--تصدير-النموذج-الرسمي-pdf)
- [Document archiving / أرشفة المستندات](#document-archiving--أرشفة-المستندات)
- [Security tips / نصائح أمنية](#security-tips--نصائح-أمنية)

## Access and language / الدخول واللغة

**English:** Open the admin URL from [RUNNING.md](RUNNING.md) (e.g. `http://127.0.0.1:8000/admin`), sign in with your admin credentials. The interface is **right-to-left (RTL)** with Arabic labels.

**العربية:** افتح رابط `/admin` وسجّل الدخول. الواجهة **من اليمين لليسار** وبعناوين عربية.

## Navigation / التنقل

**English:** Sidebar groups match the data domain:

| Navigation group (AR) | Resources | English purpose |
|----------------------|-----------|-----------------|
| **الإعدادات والبيانات المرجعية** | المناطق (العناوين)، المناطق العقارية، المباني | Location tree, real-estate area lookup, buildings (floors on building edit) |
| **السكان** | الأشخاص، العائلات | People and families |
| **العقارات والمحال** | العقارات، المحال التجارية | Real estate and shops |
| **لوحة المعلومات** | (home) | Statistics dashboard |

**العربية:** بيانات مرجعية: **المناطق** (شجرة السكن، مع تبويب المباني)، **المناطق العقارية**، **المباني** (الطوابق من تعديل المبنى). ثم **السكان**، **العقارات والمحال**، و**لوحة المعلومات** من الصفحة الرئيسية.

## Recommended workflow / سير العمل الموصى به

**English:**

1. **Locations** — Build the residential area tree (parent regions, then sub-areas).
2. **Buildings and floors** — For each location: building numbers, then floors per building (from **المباني** or the location’s buildings tab).
3. **Real-estate areas** — Define **المناطق العقارية** (lookup list for properties and statistics).
4. **Properties** — Register each property: real-estate area + property number, and residential address (location, building, floor, detail).
5. **Families** — Create family records (family card number, optional head of family, member count).
6. **People** — Add persons; assign family, phone, national ID (linked property numbers appear in the people list when attached).
7. **Relations** — On a person’s edit page, attach properties (legal status), businesses, and documents.
8. **Export** — Generate the official PDF or dashboard CSV when needed.

**العربية:**

1. **المناطق** — بناء شجرة مناطق السكن (أب ثم أبناء).
2. **المباني والطوابق** — لكل منطقة سكن: أرقام المباني، ثم الطوابق لكل مبنى (من تبويب المباني أو من صفحة المنطقة).
3. **المناطق العقارية** — تعريف المناطق العقارية (قائمة مرجعية للعقارات).
4. **العقارات** — تسجيل كل عقار: المنطقة العقارية + رقم العقار، وعنوان السكن (منطقة سكن، بناء، طابق، تفصيلي).
5. **العائلات** — إنشاء العائلات (رقم البطاقة، رب العائلة اختياري).
6. **الأشخاص** — إدخال الأفراد وربطهم بالعائلة (يظهر رقم العقار في قائمة الأشخاص عند الربط).
7. **العلاقات** — من صفحة تعديل الشخص: عقارات، محال، مستندات.
8. **التصدير** — PDF رسمي أو CSV من لوحة المعلومات عند الحاجة.

## Locations / المناطق

**English:** **المناطق (العناوين)** supports unlimited nesting via a parent location. Create top-level areas first, then child areas. This tree is **منطقة السكن** on each property. Add **buildings** and **floors** per location under **المباني** or from the location edit page. **المناطق العقارية** is a separate lookup used for real-estate registry and population statistics.

**العربية:** الشجرة = **منطقة السكن**. أضف **المباني** و**الطوابق** لكل منطقة قبل تعبئة العقارات. **المنطقة العقارية** قائمة مستقلة عن شجرة السكن.

## Families and people / العائلات والأشخاص

**English:**

- **العائلات (Families):** `family_card_number`, optional **head of family** (`head_person_id`), `total_member_count`. Use the **Members** relation tab to manage people in the family.
- **الأشخاص (People):** `national_id`, `first_name`, `father_name`, `last_name`, `phone`, link to **family**.

When editing a family, assign a head person from members. When a head person is deleted, the family head reference is cleared automatically.

**العربية:**

- **العائلات:** رقم بطاقة عائلية، رب عائلة اختياري، عدد الأفراد، تبويب **الأعضاء**.
- **الأشخاص:** رقم وطني، أسماء، هاتف، عائلة.

## Properties and businesses / العقارات والمحال

**English:**

- **العقارات (Properties):** **Real-estate layer:** `property_number`, **المنطقة العقارية** (lookup). **Residential layer:** **منطقة السكن** (location tree), **رقم البناء**, **الطابق** (cascading dropdowns), **عنوان تفصيلي**. The list shows a combined **عنوان السكن** field.
- **المحال التجارية (Businesses):** name, commercial register number, linked **property** and **owner person**.

**العربية:**

- **العقارات:** رقم عقار + منطقة عقارية؛ عنوان سكن = منطقة سكن، بناء، طابق، تفصيلي (يُعرض مجمّعاً في الجدول).
- **المحال:** اسم، سجل تجاري، عقار، مالك (شخص).

## Linking a person / ربط الشخص

**English:** Open **الأشخاص** → edit a person. Relation tabs:

| Tab | Purpose |
|-----|---------|
| العقارات (الوضع القانوني) | Attach properties with **legal status** (owner / tenant / vacant) via `person_property` pivot; default when attaching is **tenant** (مستأجر) |
| Businesses | Shops owned by this person |
| Documents | Upload archived files (title, type, file) |

Property links are managed only from the person edit page (the property resource has no resident relation tab).

**العربية:** من **الأشخاص → تعديل**: تبويب **العقارات (الوضع القانوني)** (مالك / مستأجر / فروغ — الافتراضي عند الربط: مستأجر)، **المحال**، **المستندات**. لا يوجد ربط من صفحة العقار.

## Search and filters / البحث والفلاتر

**English:**

- **Global search** (top bar): searches people by national ID, first/father/last name, and phone.
- **People list columns:** includes **أرقام العقارات** (property numbers from linked properties) and searchable property number.
- **People list filters** (filter icon on **الأشخاص**):

| Filter | Effect |
|--------|--------|
| العائلة (family) | Person belongs to selected family |
| المنطقة الجغرافية (area) | Person linked to a property in the selected location or any child area |
| المنطقة العقارية (real-estate area) | Person linked to a property in that area |
| رقم العقار (property number) | Partial match on linked property numbers |
| حجم العائلة (min family members) | Family `total_member_count` is at least the entered value |

Other resources may expose their own table filters as configured.

**العربية:**

- **البحث العام:** يبحث في الأشخاص بالرقم الوطني والأسماء والهاتف.
- **أعمدة قائمة الأشخاص:** تتضمن **أرقام العقارات** عند الربط.
- **فلاتر الأشخاص:** عائلة، منطقة جغرافية (شجرة السكن)، منطقة عقارية، رقم عقار، الحد الأدنى لعدد أفراد العائلة.

## Dashboard and CSV export / لوحة المعلومات وتصدير CSV

**English:** **لوحة المعلومات** (home) shows `NeighborhoodStatsOverview` with four stats:

| Widget | Meaning |
|--------|---------|
| إجمالي السكان | Registered people count |
| عدد العائلات | Family records count |
| المحال التجارية | Business records count |
| العقارات | Property records count |

Header action **تصدير الإحصائيات (CSV)** downloads a UTF-8 CSV (with BOM for Excel) with columns **المنطقة العقارية** and **عدد السكان**. Each person is counted once per linked property’s real-estate area (if a person has no linked property or no area, they count under **غير محدد**). A person linked to multiple areas appears in each area’s count. Filename pattern: `neighborhood-stats-YYYYMMDD-HHMMSS.csv`.

**العربية:** أربع بطاقات: السكان، العائلات، المحال، العقارات. زر **تصدير الإحصائيات (CSV)** يصدّر عدد السكان لكل منطقة عقارية (BOM UTF-8 لـ Excel). الشخص المرتبط بعدة مناطق يُحسب في كل منطقة؛ بدون عقار مرتبط يُحسب تحت **غير محدد**.

## Official PDF export / تصدير النموذج الرسمي PDF

**English:** On the **people list** or **person edit** page, use the action **نموذج رسمي (PDF)**. The system renders `resources/views/pdf/person-form.blade.php` through mPDF with RTL Arabic layout and Syrian brand styling.

PDF sections: personal information, family data (card number, member count, head of family), properties (number, real-estate area, residential address, **legal status**), and businesses. There is no income field.

The download filename is `person-{national_id}.pdf`. Letterhead uses `APP_NAME` from configuration.

If Qomra PDF fonts are missing, headings fall back to Cairo Bold (see [DEVELOPMENT.md](DEVELOPMENT.md)).

**العربية:** من قائمة الأشخاص أو صفحة التعديل: **نموذج رسمي (PDF)**. الأقسام: شخصية، عائلية، عقارات (مع الوضع القانوني)، محال. ملف RTL عربي بهوية بصرية سورية. اسم الملف يتضمن الرقم الوطني.

## Document archiving / أرشفة المستندات

**English:** From a person’s **Documents** relation tab, upload a file with title and document type. Files are stored on disk at `storage/app/documents/`; the database stores only the **relative path**, type, and title — not the file binary.

To back up archives, copy `storage/app/documents/` along with `database/database.sqlite` (see [RUNNING.md](RUNNING.md)).

**العربية:** من تبويب **المستندات** ارفع ملفاً مع عنوان ونوع. الملفات في `storage/app/documents/` والمسار فقط في قاعدة البيانات. انسخ المجلد مع قاعدة SQLite للنسخ الاحتياطي.

## Security tips / نصائح أمنية

**English:**

- Change the default `password` immediately.
- Run only on trusted machines or LAN; use strong passwords for the admin account.
- Restrict physical access to the server and backup media containing SQLite and documents.

**العربية:** غيّر كلمة المرور الافتراضية فوراً. شغّل التطبيق على أجهزة موثوقة أو شبكة محلية محمية. احمِ النسخ الاحتياطية لقاعدة البيانات والمستندات.
