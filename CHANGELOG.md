# Change Log for Fresh-Advance Electronic-Invoice module

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

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
