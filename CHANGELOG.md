# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [4.1.6] - 2020-12-16

### Security
- Sanitized and escaped all potential unsafe data.

## [4.1.5] - 2020-12-13

### Security
- Escaped html attributes to avoid possible XSS exploits.

## [4.1.4] - 2020-11-28

### Updated
- Tested upto WordPress 5.5.3

## [4.1.3] - 2019-12-25

### Fixed
- Unique voting now correctly forbids multiple ratings by same IP. (GitHub PR #91).
- Options are now correctly synced when installing, upgrading and activating.
- Use absolute change log links in docs.

## [4.1.2] - 2019-11-05

### Fixed
- Special characters are now escaped in the title of structured data.

## [4.1.1] - 2019-10-29

### Fixed
- Factory/default options are now synced on activation.

## [4.1.0] - 2019-10-28

### Added
- Customizable gap/gutter between stars.
- Structured data in pages.

### Updated
- Svg icons

### Fixed
- Activation only ports the previous options if version was lower than 3.
- Relative star svg links instead of absolute links are now used in css.

## [4.0.0] - 2019-10-26

- Stability
