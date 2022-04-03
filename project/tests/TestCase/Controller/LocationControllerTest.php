<?php

declare(strict_types=1);

namespace App\Tests\TestCase\Controller;

use App\Repository\AbstractElasticSearchRepository;
use App\Repository\LocationRepository;
use App\Tests\JsonSchema\LocationSchema;
use App\Tests\TestCase\Traits\ElasticsearchTrait;
use Elastica\Document;
use PhpSolution\FunctionalTest\TestCase\ApiTestCase;

class LocationControllerTest extends ApiTestCase
{
    use ElasticsearchTrait;

    private const NEAREST_ENDPOINT = 'locations/nearest';

    private function loadES(string $file, AbstractElasticSearchRepository $repository): array
    {
        $items = $this->getFixtures($file);
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

    private function loadFixtures(): array
    {
        /** @var LocationRepository $repository */
        $repository = self::getContainer()->get(LocationRepository::class);

        return $this->loadES($this->getFilePath(), $repository);
    }

    public function testNearestWithFilterSuccess(): void
    {
       $fixtures = $this->loadFixtures();

       /** @var Document $document */
       $document = $fixtures[0];
       $city = $document->getData();

       $params = [
            'filter' => [
                'type' => 'city',
                'distance' => 60,
                'lon' => $city['location_geo'][0],
                'lat' => $city['location_geo'][1],
            ]
       ];

        $response = static::createTester()
            ->sendGet(\sprintf('%s?%s', self::NEAREST_ENDPOINT, http_build_query($params)))
            ->toArray();

        $expected = ['Pelican Bay', 'Highland Village', 'Chico', 'Shady Shores', 'Boyd'];
        $actual = array_column($response['items'], 'name');

        self::assertEquals($expected, $actual);
        self::assertNotContains($city['name'], $actual);
        self::assertDataMatchesJsonType($response, LocationSchema::getCollectionJsonSchema());
    }
}
