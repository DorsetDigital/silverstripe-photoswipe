<?php

namespace DorsetDigital\SilverstripePhotoswipe\Extensions;

use DNADesign\Elemental\Models\BaseElement;
use DorsetDigital\SchemaManager\Model\Schema\ImageGallerySchema;
use DorsetDigital\SilverstripePhotoswipe\Elements\GalleryElement;
use DorsetDigital\SilverstripePhotoswipe\Schema\GallerySchemaBuilder;
use SilverStripe\Core\Extension;

class ElementalGallerySchemaExtension extends Extension
{
    public function updateSchemaManagerEntities(array &$entities): void
    {
        if (!class_exists(ImageGallerySchema::class)
            || !class_exists(BaseElement::class)
            || !$this->owner->hasMethod('ElementalArea')
        ) {
            return;
        }

        $area = $this->owner->ElementalArea();
        if (!$area || !$area->exists()) {
            return;
        }

        foreach ($area->Elements() as $element) {
            if (!$element instanceof GalleryElement) {
                continue;
            }

            $schema = GallerySchemaBuilder::forElement($element, $this->owner);
            if ($schema) {
                $entities[] = $schema;
            }
        }
    }
}
