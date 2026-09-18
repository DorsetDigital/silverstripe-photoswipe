# Silverstripe PhotoSwipe

Responsive image galleries for Silverstripe CMS 6, powered by PhotoSwipe 5.

The module provides a ready-to-use Gallery Page, reusable extensions for adding a gallery to your own page types, and optional Elemental integration. PhotoSwipe and the default gallery layout use modern JavaScript and CSS with no jQuery or Bootstrap dependency.

## Requirements

- PHP 8.3+
- Silverstripe CMS 6
- [bummzack/sortablefile](https://github.com/bummzack/sortablefile) 3.x

[dnadesign/silverstripe-elemental](https://github.com/silverstripe/silverstripe-elemental) is optional. If it is installed, a PhotoSwipe Gallery element is automatically available.

## Installation

Install the module with Composer:

```bash
composer require dorsetdigital/silverstripe-photoswipe:^2
```

Then run a development build:

```bash
vendor/bin/sake dev/build flush=1
```

The module includes its compiled frontend assets, so applications installing it through Composer do not need to run npm or Vite.

## Gallery Page

A `Gallery Page` page type is included and enabled by default. Create one in the CMS, add images to the Gallery tab and reorder them as required.

The supplied page template renders the page content followed by the gallery. A project can override the template in the usual Silverstripe way.

If a project does not want the bundled page type to be available in the CMS, disable it in project YAML:

```yaml
DorsetDigital\SilverstripePhotoswipe\Pages\GalleryPage:
  hide_ancestor: true
```

## Adding a gallery to another page type

Apply `GalleryExtension` to the page class and `GalleryControllerExtension` to its controller:

```yaml
---
Name: app-photoswipe
After:
  - '#silverstripe-photoswipe-gallery'
---
App\Model\Page\ContentPage:
  extensions:
    - DorsetDigital\SilverstripePhotoswipe\Extensions\GalleryExtension

App\Control\ContentPageController:
  extensions:
    - DorsetDigital\SilverstripePhotoswipe\Extensions\GalleryControllerExtension
```

The page gains a Gallery tab in the CMS. Render the gallery in its template with:

```ss
$Gallery
```

Frontend requirements are only added when the page has gallery images.

## Elemental

Elemental is an optional dependency. When `dnadesign/silverstripe-elemental` is installed, the module automatically exposes a `PhotoSwipe Gallery` block. No additional PhotoSwipe YAML is required.

A project without Elemental can install and use this module normally. If Elemental is installed later, run `dev/build flush=1` and the gallery element will become available.

## Frontend and styling

Gallery images are rendered as ordinary links, so the gallery remains usable without JavaScript. PhotoSwipe progressively enhances those links into the lightbox.

The supplied template generates WebP images with a maximum width of 1600px for the lightbox and 550px for thumbnails. Images include intrinsic dimensions, lazy loading and asynchronous decoding.

The module always includes the CSS required by PhotoSwipe. It also includes a lightweight responsive CSS Grid layout by default. Browsers with CSS masonry support receive a progressive masonry enhancement.

To use your project's own gallery layout while retaining PhotoSwipe's functional CSS, disable only the module's default gallery styling:

```yaml
DorsetDigital\SilverstripePhotoswipe\Services\GalleryRequirements:
  include_default_css: false
```

The primary styling hooks are:

```text
.photoswipe-gallery
.photoswipe-gallery__item
.photoswipe-gallery__link
.photoswipe-gallery__image
```

## Templates

The shared gallery templates are:

```text
DorsetDigital/SilverstripePhotoswipe/Includes/Gallery.ss
DorsetDigital/SilverstripePhotoswipe/Includes/GalleryImage.ss
```

Both the Gallery Page and Elemental implementation use the same gallery rendering, so project-level template overrides can be shared between them.

## Upgrading from 1.x

Version 2 is a major release targeting Silverstripe CMS 6 and PhotoSwipe 5. It removes the old jQuery/PhotoSwipe 4 frontend and contains breaking namespace and implementation changes.

The former `dorsetdigital/silverstripe-photoswipe-elemental` package has been folded into this module. New installations should not install the separate Elemental package.

### Experimental legacy Elemental migration

An experimental build task is included for sites migrating existing gallery blocks from `dorsetdigital/silverstripe-photoswipe-elemental`:

```bash
vendor/bin/sake migrate-legacy-photoswipe-elemental-galleries
```

This task updates the stored Elemental class name while preserving the existing gallery table and image relationships.

**This migration has not yet been verified against a production legacy installation. Back up the database before running it and test the migration in a non-production environment first. Version 2 does not currently guarantee automatic migration of legacy Elemental galleries.**

## Development

Frontend source is in `client/src` and is built with Vite.

```bash
npm install
npm run build
```

For development with automatic rebuilds:

```bash
npm run dev
```

Compiled files in `client/dist` are committed to the package because they are exposed as Silverstripe module resources and consumed directly by Composer installations.

## Credits

- [PhotoSwipe](https://photoswipe.com/)
- [SortableFile](https://github.com/bummzack/sortablefile)
- [Silverstripe Elemental](https://github.com/silverstripe/silverstripe-elemental)
