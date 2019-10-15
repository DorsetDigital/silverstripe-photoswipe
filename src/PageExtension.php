<?php

namespace DorsetDigital\SilverstripePhotoswipe;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use Bummzack\SortableFile\Forms\SortableUploadField;

class PageExtension extends DataExtension
{

    private static $db = [
        'IncludeTitles' => 'Boolean'
    ];

    private static $many_many = [
        'GalleryImages' => Image::class
    ];

    private static $many_many_extraFields = [
        'GalleryImages' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'GalleryImages'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Gallery', [
            CheckboxField::create('IncludeTitles')
                ->setTitle(_t(__CLASS__ . '.inctitles', "Include image titles as captions?")),
            SortableUploadField::create('GalleryImages', $this->owner->fieldLabel('Images')
            )->setFolderName('galleryimages')->setAllowedFileCategories('image/supported')
        ]);
    }

    public function getGallery()
    {
        if ($this->owner->GalleryImages()->count() > 0) {
            $sortedImages = $this->owner->GalleryImages()->sort('SortOrder');
            return $this->owner->renderWith('Gallery', ['SortedImages' => $sortedImages]);
        }
    }

}