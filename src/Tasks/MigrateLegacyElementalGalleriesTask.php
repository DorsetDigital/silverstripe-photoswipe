<?php

namespace DorsetDigital\SilverstripePhotoswipe\Tasks;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

if (!class_exists(BaseElement::class)) {
    return;
}

class MigrateLegacyElementalGalleriesTask extends BuildTask
{
    private const LEGACY_CLASS = 'DorsetDigital\\Elements\\PhotoSwipe\\Models\\Gallery';
    private const NEW_CLASS = 'DorsetDigital\\SilverstripePhotoswipe\\Elements\\GalleryElement';

    protected string $title = 'Migrate legacy PhotoSwipe Elemental galleries';
    protected static string $description = 'Updates legacy silverstripe-photoswipe-elemental ClassName values for PhotoSwipe v2.';

    protected static string $commandName = 'migrate-legacy-photoswipe-elemental-galleries';

    protected function execute(InputInterface $input, PolyOutput $output): int
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

            $output->writeln(sprintf('Migrated %d record(s) in %s', $count, $table));
        }

        if (!$found) {
            $output->writeln('No legacy PhotoSwipe Elemental galleries found.');
            return Command::SUCCESS;
        }

        $output->writeln(sprintf('Migration complete: %d record(s) updated.', $found));

        return Command::SUCCESS;
    }
}
