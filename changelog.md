# Changelog

All notable changes to `Blog` will be documented in this file.

## Version 1.2.4

### Fixed
- Assets now have absolute URL's.

## Version 1.2.1

### Fixed
- Navigation overlap on small screens.

## Version 1.2.0

### New
- Configure admin menus in the config file.
- New admin UI based on [tailwindcss](https://tailwindcss.com).

### Fixed
- SVG icons inside buttons didn't trigger the confirm dialog.
- Fix per page not honored on post list.

## Version 1.1.1

### Fixed
- Response cache not cleared.
- Disable response cache in the `.env` with `RESPONSE_CACHE_ENABLED=false`.

## Version 1.1

### Added
- Specify a custom markdown parser in the `config/blog.php` file.
- Images now have a `srcset` attribute.
- Detect high pixel density images and specify that in the image's `srcset` (requires `imagick` PHP extension).

## Version 1.0

### Added
- Everything.


