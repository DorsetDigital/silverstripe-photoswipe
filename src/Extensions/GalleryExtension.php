<?php

namespace DorsetDigital\SilverstripePhotoswipe\Extensions;

use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class GalleryExtension extends DataExtension
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
}
