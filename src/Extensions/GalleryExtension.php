<?php

namespace DorsetDigital\SilverstripePhotoswipe\Extensions;

use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLText;
use DorsetDigital\SchemaManager\Model\Schema\ImageGallerySchema;
use DorsetDigital\SilverstripePhotoswipe\Pages\GalleryPage;

class GalleryExtension extends Extension
{
    private static $many_many = [
        'GalleryImages' => Image::class,
    ];

    private static $many_many_extraFields = [
        'GalleryImages' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'GalleryImages',
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->addFieldToTab(
            'Root.Gallery',
            SortableUploadField::create('GalleryImages', _t(__CLASS__ . '.IMAGES', 'Images'))
                ->setFolderName('galleryimages')
                ->setAllowedFileCategories('image/supported')
        );
    }

    public function getSortedGalleryImages()
    {
        return $this->owner->GalleryImages()->sort('SortOrder');
    }

    public function hasGalleryImages(): bool
    {
        return $this->owner->GalleryImages()->exists();
    }

    public function updateSchemaManagerEntities(array &$entities): void
    {
        if (!class_exists(ImageGallerySchema::class) || !$this->hasGalleryImages()) {
            return;
        }

        $pageURL = $this->owner->AbsoluteLink();
        $schema = ImageGallerySchema::create(
            $pageURL,
            $this->owner->Title,
            $this->owner->MetaDescription ?: null
        );

        foreach ($this->getSortedGalleryImages() as $image) {
            $schema->addImage(
                $image->getAbsoluteURL(),
                $image->Title ?: null,
                null,
                $image->getWidth(),
                $image->getHeight()
            );
        }

        $firstImage = $this->getSortedGalleryImages()->first();
        if ($firstImage) {
            $schema->setThumbnail($firstImage->getAbsoluteURL());
        }

        if ($this->owner instanceof GalleryPage) {
            $schema->setMainEntityOfPage($pageURL);
        }

        $entities[] = $schema;
    }

    public function getGallery(): ?DBHTMLText
    {
        if (!$this->hasGalleryImages()) {
            return null;
        }

        return $this->owner->renderWith(
            'DorsetDigital\\SilverstripePhotoswipe\\Includes\\Gallery'
        );
    }
}
