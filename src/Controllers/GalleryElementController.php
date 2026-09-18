<?php

namespace DorsetDigital\SilverstripePhotoswipe\Controllers;

use DNADesign\Elemental\Controllers\ElementController;
use DorsetDigital\SilverstripePhotoswipe\Services\GalleryRequirements;

class GalleryElementController extends ElementController
{
    protected function init(): void
    {
        parent::init();

        if ($this->element->hasGalleryImages()) {
            GalleryRequirements::include();
        }
    }
}
