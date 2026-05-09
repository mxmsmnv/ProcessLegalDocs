# Changelog

All notable changes to ProcessLegalDocs are documented here.
This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-05-09

### Changed

- Updated minimum requirements to ProcessWire `3.0.255` and PHP `8.3`.
- Improved the admin UI using AdminThemeUikit design-system components and tokens: dashboard summary cards, clearer document actions, responsive jurisdiction cards, a sticky generation bar, and a more readable progress view.
- Expanded jurisdiction presets from 23 to 59, adding EEA/GDPR, Switzerland/FADP, EU country-level GDPR variants, Ukraine, Serbia, Turkey, and Russia/Federal Law 152-FZ.
- Expanded jurisdiction presets from 59 to 93, adding US state privacy laws, Latin American privacy laws, African data protection laws, and additional APAC/Middle East presets.
- Added realtime jurisdiction search/filtering and compact flag markers on the generation screen.
- Expanded supported languages from 17 to 44 and limited each jurisdiction language selector to relevant local languages plus practical fallback languages.
- Added business, audience, data processing, third-party processor, cookie, refund, and subscription settings to improve prompt accuracy.
- Added service presets for processors, analytics, payments, email/marketing, and cookie consent tools.
- Added review status metadata and optional ProcessWire page publishing for generated legal documents.
- Added ProcessWire module version `100`.

## [0.1.0] - 2026-04-28

### Initial Release

- AI-powered legal document generation via Context module gateway
- 23 jurisdictions: EU/GDPR, UK GDPR, US/CCPA, COPPA, Canada/PIPEDA, Australia, Brazil/LGPD, Japan/APPI, South Korea/PIPA, China/PIPL, India/DPDP, Singapore/PDPA, Thailand/PDPA, Indonesia/PDP, Malaysia/PDPA, Philippines/DPA, UAE/PDPL, Saudi Arabia/PDPL, Qatar/PDPPL, Bahrain/PDPL, Egypt/DPL, Morocco/Law 09-08, Generic
- 17 languages: English, German, French, Spanish, Italian, Portuguese, Dutch, Polish, Russian, Ukrainian, Japanese, Chinese (Simplified), Arabic, Korean, Thai, Indonesian, Malay
- Document types: Privacy Policy, Cookie Policy, Terms of Use, Data Processing Agreement, CCPA Notice, Refund Policy, Disclaimer
- YAML frontmatter in all generated files
- Legal disclaimer prepended to every document
- Dashboard with document list, preview, download, and regenerate actions
- Real-time generation progress UI
- Works without Context module (generic template mode)
- File storage at `/site/assets/legal/{jurisdiction}/`
- `.htaccess` protection for legal docs directory
- Programmatic API via `$legal->getGenerator()`
