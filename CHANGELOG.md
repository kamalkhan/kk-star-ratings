# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [3.1.0] - 2019-07-24

### Added
- Bottom margin added when bottom position in effect.
- Ability to reset ratings for individual posts/pages.
- Enable/disable star ratings for individual posts/pages.
- Take manual control of the auto embedded markup to avoid duplication when using in a template.

### Fixed
- Markup is now hidden under AMP.
- Assets are now enqueued when manually/forcefully loading the markup via template function.

### Changed
- Default colors have been updated.
- Default size is now 22px instead of 24px.
- Structured data now uses ratingCount instead of reviewCount.

### Removed
- Nothing

### Deprecated
- Nothing

### Security
- Nothing

## [3.0.0] - 2019-07-18

### Added
- Optionally allow guests to vote.
- Ratings can also be included in publicly accessible custom posts.

### Fixed
- Google rich snippets.
- AJAX call on every load causing high CPU usage.

### Changed
- Stars are now based on svg.
- Appearance has been simplified.
- Html based structured data has been replaced by json based structured data.
- kk_star_ratings_get function no longer includes the post_title key.

### Removed
- Labels have been removed.
- Top posts widget has been removed in favor of a future addon.
- Admin table colum has been removed in favor of a future addon.

### Deprecated
- Nothing

### Security
- Nothing
