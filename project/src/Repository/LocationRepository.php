<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Request\LocationNearestFilterDto;
use Elastica\Query;
use Elastica\Result;

class LocationRepository extends AbstractElasticSearchRepository
{
    public const INDEX_ALIAS = 'locations';
    public const NEAREST_LOCATIONS_SIZE = 5;

    public function getIndexAlias(): string
    {
        return self::INDEX_ALIAS;
    }

    public function findNearest(LocationNearestFilterDto $filter): array
    {
        $coordinates = [(float)$filter->lon, (float)$filter->lat];

        $mustCondition = [
            'match' => [
                'type' => $filter->type
            ]
        ];

        $filterCondition = [
            'geo_distance' => [
                'distance' => \sprintf('%skm', $filter->distance),
                'location_geo' => $coordinates
            ]
        ];

        $sort = [
            '_geo_distance' => [
                'location_geo' => $coordinates,
                'order' => 'asc',
                'unit' => 'km',
                'mode' => 'min',
            ]
        ];

        $requestQuery = [
            'size' => self::NEAREST_LOCATIONS_SIZE + 1,
            'query' => ['bool' => ['must' => $mustCondition, 'filter' => $filterCondition]],
            'sort' => [$sort]
        ];

        $resultEs = $this->initIndex()->search(new Query($requestQuery))->getResults();
        $result = array_map(fn(Result $doc) => $doc->getData(), $resultEs);

        return array_filter($result, fn(array $data) => ($data['location_geo'] ?? []) !== $coordinates);
    }
}
