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
        $mustCondition = [
            'match' => [
                'type' => $filter->type
            ]
        ];

        $filterCondition = [
            'geo_distance' => [
                'distance' => \sprintf('%skm', $filter->distance),
                'location_geo' => [(float)$filter->lon, (float)$filter->lat]
            ]
        ];

        $requestQuery = [
            'size' => self::NEAREST_LOCATIONS_SIZE,
            'query' => ['bool' => ['must' => $mustCondition, 'filter' => $filterCondition]]
        ];
        $result = $this->initIndex()->search(new Query($requestQuery))->getResults();

        return array_map(fn(Result $doc) => $doc->getData(), $result);
    }
}
