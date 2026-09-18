<?php

namespace DorsetDigital\SilverstripePhotoswipe\Services;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\Requirements;

class GalleryRequirements
{
    use Configurable;

    private static bool $include_default_css = true;

    public static function include(): void
    {
        Requirements::javascript(
            'dorsetdigital/silverstripe-photoswipe:client/dist/gallery.js',
            ['type' => 'module']
        );

        Requirements::css(
            'dorsetdigital/silverstripe-photoswipe:client/dist/photoswipe.css'
        );

        if (static::config()->get('include_default_css')) {
            Requirements::css(
                'dorsetdigital/silverstripe-photoswipe:client/dist/gallery-styles.css'
            );
        }
    }
}
