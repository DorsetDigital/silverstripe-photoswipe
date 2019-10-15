<?php

namespace DorsetDigital\SilverstripePhotoswipe;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class ControllerExtension extends Extension
{
    public function onAfterInit()
    {
        Requirements::javascript('dorsetdigital/silverstripe-photoswipe:client/dist/photoswipe.min.js');
        Requirements::javascript('dorsetdigital/silverstripe-photoswipe:client/dist/photoswipe-ui-default.min.js');
        Requirements::javascript('dorsetdigital/silverstripe-photoswipe:client/dist/gallery.min.js');
        Requirements::css('dorsetdigital/silverstripe-photoswipe:client/dist/gallery.css');
    }
}