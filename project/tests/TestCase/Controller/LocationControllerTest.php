<?php

declare(strict_types=1);

namespace App\Tests\TestCase\Controller;

use App\Repository\AbstractElasticSearchRepository;
use App\Repository\LocationRepository;
use App\Tests\TestCase\Traits\ElasticsearchTrait;
use Elastica\Document;
use PhpSolution\FunctionalTest\TestCase\ApiTestCase;

class LocationControllerTest extends ApiTestCase
{
    use ElasticsearchTrait;

    private function loadES(string $file, AbstractElasticSearchRepository $repository): array
    {
        $items = $this->loadFixtures($file);
        $documents = array_map(function (array $data) {
            return new Document(null, [
                'name' => $data[0],
                'type' => 'city',
                'location_geo' => [(float)$data[1], (float)$data[2]],
            ]);
        }, $items);

        $index = $this->initializeIndex($repository);
        $this->loadDocuments($index, $documents);

        return $documents;
    }

    private function getFilePath(): string
    {
        return __DIR__.'/../../DataFixtures/Stub/cities.csv';
    }

    public function testNearestWithFilter(): void
    {
        /** @var LocationRepository $repository */
        $repository = self::getContainer()->get(LocationRepository::class);

        $this->loadES($this->getFilePath(), $repository);

        $params = [
            'filter' => [
                'type' => 'city',
                'distance' => 60,
                'lat' => 33.2342834,
                'lon' => -97.5861393
            ]
        ];

        $res = static::createTester()
            ->sendGet(\sprintf('locations/nearest?%s', http_build_query($params)))
            ->toArray();
dd($res);
        self::assertEquals(['test' => 'Hello world'], $res);
    }
}
