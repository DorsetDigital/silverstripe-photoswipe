<?php

namespace DorsetDigital\SilverstripePhotoswipe\Extensions;

use DorsetDigital\SilverstripePhotoswipe\Services\GalleryRequirements;
use SilverStripe\Core\Extension;

class GalleryControllerExtension extends Extension
{
    public function onAfterInit(): void
    {
        $record = $this->owner->data();

        if ($record && $record->hasMethod('hasGalleryImages') && $record->hasGalleryImages()) {
            GalleryRequirements::include();
        }
    }
}
