<?php

namespace DorsetDigital\SilverstripePhotoswipe\Pages;

use DorsetDigital\SilverstripePhotoswipe\Controllers\GalleryPageController;
use Page;

class GalleryPage extends Page
{
    private static string $table_name = 'PhotoSwipeGalleryPage';
    private static string $singular_name = 'Gallery Page';
    private static string $plural_name = 'Gallery Pages';
    private static string $description = 'A page containing a responsive image gallery';
    private static string $controller_name = GalleryPageController::class;
}
