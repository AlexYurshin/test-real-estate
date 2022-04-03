<?php

declare(strict_types=1);

namespace App\Tests\TestCase\Traits;

use App\Repository\AbstractElasticSearchRepository;
use Elastica\Index;

trait ElasticsearchTrait
{
    private function initializeIndex(AbstractElasticSearchRepository $repository): Index
    {
        $index = $repository->createIndex(true);

        self::assertEquals(0, $index->count());

        return $index;
    }

    private function loadDocuments(Index $index, array $documents): void
    {
        foreach ($documents as $document)
        {
            $index->addDocument($document);
        }
        $index->refresh();

        self::assertEquals(count($documents), $index->count());
    }

    private function getFixtures(string $file): array
    {
        $items = [];

        $file = fopen($file, 'r');
        while (($line = fgetcsv($file)) !== false) {
            $items[] = $line;
        }
        fclose($file);

        return $items;
    }
}
