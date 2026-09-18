<?php

namespace DorsetDigital\SilverstripePhotoswipe\Tasks;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;

if (!class_exists(BaseElement::class)) {
    return;
}

class MigrateLegacyElementalGalleriesTask extends BuildTask
{
    private const LEGACY_CLASS = 'DorsetDigital\\Elements\\PhotoSwipe\\Models\\Gallery';
    private const NEW_CLASS = 'DorsetDigital\\SilverstripePhotoswipe\\Elements\\GalleryElement';

    protected $title = 'Migrate legacy PhotoSwipe Elemental galleries';
    protected $description = 'Updates legacy silverstripe-photoswipe-elemental ClassName values for PhotoSwipe v2.';

    private static string $segment = 'migrate-legacy-photoswipe-elemental-galleries';

    public function run($request): void
    {
        $tables = [
            'ElementalAreaElement',
            'ElementalAreaElement_Live',
            'ElementalAreaElement_Versions',
        ];

        $found = 0;

        foreach ($tables as $table) {
            if (!DB::get_schema()->hasTable($table)) {
                continue;
            }

            $count = (int) DB::query(sprintf(
                'SELECT COUNT(*) FROM "%s" WHERE "ClassName" = ?',
                $table
            ), [self::LEGACY_CLASS])->value();

            if (!$count) {
                continue;
            }

            $found += $count;
            DB::prepared_query(sprintf(
                'UPDATE "%s" SET "ClassName" = ? WHERE "ClassName" = ?',
                $table
            ), [self::NEW_CLASS, self::LEGACY_CLASS]);

            $this->output(sprintf('Migrated %d record(s) in %s', $count, $table));
        }

        if (!$found) {
            $this->output('No legacy PhotoSwipe Elemental galleries found.');
            return;
        }

        $this->output(sprintf('Migration complete: %d record(s) updated.', $found));
    }

    private function output(string $message): void
    {
        if (Director::is_cli()) {
            echo $message . PHP_EOL;
            return;
        }

        echo htmlspecialchars($message) . '<br>';
    }
}
