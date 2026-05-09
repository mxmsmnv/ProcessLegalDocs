# ProcessLegalDocs - AI Agent Integration

This module uses the **Context module AI gateway** for document generation.

## Architecture

```
ProcessLegalDocs
└── LegalDocsGenerator
    └── wire('context')->ai()  ← Context module AI gateway
        └── OpenRouter / OpenAI / Custom
```

## Key Files

| File | Purpose |
|------|---------|
| `ProcessLegalDocs.module.php` | Main Process module, UI, settings |
| `ProcessLegalDocs.config.php` | Jurisdictions, document types, language lists, legal requirements |
| `LegalDocsGenerator.php` | AI prompt builder, Context integration, file writer |

## How Generation Works

1. User selects jurisdiction + language + documents in admin UI
2. AJAX POST to `executeGenerate()`
3. `LegalDocsGenerator::generate()` called
4. Generator reads Context export files if available (`structure.toon`, `templates.toon`)
5. Detects personal data fields, features, modules from site
6. Builds jurisdiction-specific AI prompt
7. Calls `wire('context')->ai()->chat()`
8. Strips code fences from response
9. Prepends YAML frontmatter + disclaimer
10. Saves to `/site/assets/legal/{jurisdiction}/{slug}.{lang}.md`

## Adding a New Jurisdiction

In `ProcessLegalDocs.config.php`:

1. Add to `getJurisdictions()`:
```php
'xx_law' => ['name' => 'Country / Law Name', 'region' => 'Region'],
```

2. Add to `getJurisdictionDocuments()`:
```php
'xx_law' => [
    'required' => ['privacy-policy', 'terms-of-use'],
    'optional' => ['refund-policy', 'disclaimer'],
],
```

3. Add to `getJurisdictionRequirements()`:
```php
'xx_law' => [
    'law' => 'Full Law Name and Year',
    'requirements' => [
        'Key requirement 1',
        'Key requirement 2',
    ],
],
```

## Adding a New Document Type

In `ProcessLegalDocs.config.php`, add to `getDocumentTypes()`:
```php
'my-document' => ['label' => 'My Document', 'slug' => 'my-document'],
```

Then add it to the relevant jurisdictions in `getJurisdictionDocuments()`.

## Generated File Format

```
/site/assets/legal/
└── {jurisdiction}/
    └── {document-slug}.{lang-code}.md
```

Each file:
```
---
title: "Privacy Policy"
jurisdiction: eu_gdpr
language: en
generated: 2026-04-28
owner: "Company Name"
website: "https://example.com"
generator: ProcessLegalDocs for ProcessWire
---

> ⚠️ Legal Disclaimer...

---

# Privacy Policy
... document content ...
```

## Security Notes

- Generated files are not web-accessible (`.htaccess` deny)
- Download served via `executeDownload()` with sanitized parameters
- No user input is passed directly to AI without sanitization
