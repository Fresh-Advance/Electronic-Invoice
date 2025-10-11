# Change Log for Fresh-Advance Electronic-Invoice module

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v1.0.0-rc.7] - 2025-10-12

### Added
- New setting - Company registry information for adding more company information in the Note field of the invoice

### Changed
- Do not translate item titles anymore, it should be taken from the OrderArticle directly.
- Set invoice date as delivery date (this may get more configuration options in the future)

## [v1.0.0-rc.6] - 2025-08-05

### Removed
- Adjustements to net prices are removed. The module works only with shops configured for Net prices currently, while the bug in shop is not fixed.

## [v1.0.0-rc.5] - 2025-06-25

### Fixed
- Update by Invoice module v5.0.0-rc.2 changes

## [v1.0.0-rc.4] - 2025-06-17

### Fixed
- Fixed incorrect OrderDifferenceCalculatorInterface service definition
- Handle items with zero vat with correct vat code

## [v1.0.0-rc.3] - 2025-06-12

### Fixed
- Adjust line net values because of rounding issues, to fit the EN-16931 standard validation without changing totals.

## [v1.0.0-rc.2] - 2025-06-10

### Fixed
- Fix too high conflict shop version

## [v1.0.0-rc.1] - 2025-06-08

### Added
- ZUGFeRD EN-16931 format support

[v1.0.0-rc.6]: https://github.com/Fresh-Advance/Electronic-Invoice/compare/v1.0.0-rc.5...v1.0.0-rc.6
[v1.0.0-rc.5]: https://github.com/Fresh-Advance/Electronic-Invoice/compare/v1.0.0-rc.4...v1.0.0-rc.5
[v1.0.0-rc.4]: https://github.com/Fresh-Advance/Electronic-Invoice/compare/v1.0.0-rc.3...v1.0.0-rc.4
[v1.0.0-rc.3]: https://github.com/Fresh-Advance/Electronic-Invoice/compare/v1.0.0-rc.2...v1.0.0-rc.3
[v1.0.0-rc.2]: https://github.com/Fresh-Advance/Electronic-Invoice/compare/v1.0.0-rc.1...v1.0.0-rc.2
[v1.0.0-rc.1]: https://github.com/Fresh-Advance/Electronic-Invoice/compare/9e7f4664f4c...v1.0.0-rc.1