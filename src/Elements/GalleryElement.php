<?php

namespace DorsetDigital\SilverstripePhotoswipe\Elements;

use Bummzack\SortableFile\Forms\SortableUploadField;
use DNADesign\Elemental\Models\BaseElement;

if (!class_exists(BaseElement::class)) {
    return;
}

use DorsetDigital\SilverstripePhotoswipe\Controllers\GalleryElementController;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use DorsetDigital\SchemaManager\Model\Schema\ImageGallerySchema;

class GalleryElement extends BaseElement
{
    private static string $table_name = 'DorsetDigital_Elements_PhotoSwipe';
    private static string $singular_name = 'PhotoSwipe Gallery';
    private static string $plural_name = 'PhotoSwipe Galleries';
    private static string $description = 'Responsive image gallery';
    private static string $controller_class = GalleryElementController::class;
    private static bool $inline_editable = false;

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

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('GalleryImages');
        $fields->addFieldToTab(
            'Root.Main',
            SortableUploadField::create('GalleryImages', $this->fieldLabel('GalleryImages'))
                ->setFolderName('galleryimages')
                ->setAllowedFileCategories('image/supported')
        );

        return $fields;
    }

    public function getSortedGalleryImages()
    {
        return $this->GalleryImages()->sort('SortOrder');
    }

    public function hasGalleryImages(): bool
    {
        return $this->GalleryImages()->exists();
    }

    public function updateSchemaManagerEntities(array &$entities): void
    {
        if (!class_exists(ImageGallerySchema::class) || !$this->hasGalleryImages()) {
            return;
        }

        $page = $this->getPage();
        if (!$page) {
            return;
        }

        $schema = ImageGallerySchema::create(
            $page->AbsoluteLink(),
            $this->Title ?: null,
            null,
            (string) $this->ID
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

        $entities[] = $schema;
    }

    public function getType(): string
    {
        return 'PhotoSwipe Gallery';
    }
}
