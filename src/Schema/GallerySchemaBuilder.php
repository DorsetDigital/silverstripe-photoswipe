<?php

namespace DorsetDigital\SilverstripePhotoswipe\Schema;

use DorsetDigital\SchemaManager\Model\Schema\ImageGallerySchema;
use DorsetDigital\SilverstripePhotoswipe\Elements\GalleryElement;
use DorsetDigital\SilverstripePhotoswipe\Pages\GalleryPage;
use SilverStripe\CMS\Model\SiteTree;

class GallerySchemaBuilder
{
    public static function forPageGallery(SiteTree $page): ?ImageGallerySchema
    {
        if (!class_exists(ImageGallerySchema::class)
            || !$page->hasMethod('hasGalleryImages')
            || !$page->hasGalleryImages()
        ) {
            return null;
        }

        $schema = self::build(
            $page->AbsoluteLink(),
            $page->getSortedGalleryImages(),
            $page->Title,
            $page->MetaDescription ?: null
        );

        if ($page instanceof GalleryPage) {
            $schema->setMainEntityOfPage($page->AbsoluteLink());
        }

        return $schema;
    }

    public static function forElement(GalleryElement $element, SiteTree $page): ?ImageGallerySchema
    {
        if (!class_exists(ImageGallerySchema::class) || !$element->hasGalleryImages()) {
            return null;
        }

        return self::build(
            $page->AbsoluteLink(),
            $element->getSortedGalleryImages(),
            $element->Title ?: null,
            null,
            (string) $element->ID
        );
    }

    private static function build(
        string $pageURL,
        iterable $images,
        ?string $name = null,
        ?string $description = null,
        ?string $identifier = null
    ): ImageGallerySchema {
        $schema = ImageGallerySchema::create($pageURL, $name, $description, $identifier);
        $firstImage = null;

        foreach ($images as $image) {
            $firstImage ??= $image;

            $schema->addImage(
                $image->getAbsoluteURL(),
                $image->Title ?: null,
                null,
                $image->getWidth(),
                $image->getHeight()
            );
        }

        if ($firstImage) {
            $schema->setThumbnail($firstImage->getAbsoluteURL());
        }

        return $schema;
    }
}
