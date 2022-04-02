<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Request\LocationNearestFilterDto;

class LocationRepository extends AbstractElasticSearchRepository
{
    public const INDEX_ALIAS = 'locations';

    public function getIndexAlias(): string
    {
        return self::INDEX_ALIAS;
    }

    public function findNearest(LocationNearestFilterDto $filter): array
    {
        $map = [];

        $map[] = [
            'name' => 'Test name',
            'type' => 'city',
            'lat' => 12.12,
            'lon' => 15,
        ];

        return $map;
    }
}
