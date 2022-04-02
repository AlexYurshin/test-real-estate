<?php

declare(strict_types=1);

namespace App\Tests\TestCase\Controller;

use PhpSolution\FunctionalTest\TestCase\ApiTestCase;

class LocationControllerTest extends ApiTestCase
{
    public function testNearestWithFilter(): void
    {
        $params = [
            'filter' => [
                'type' => 'city',
                'distance' => 26,
                'lat' => 29.12,
                'lon' => -28.56
            ]
        ];

        $res = static::createTester()
            ->sendGet(\sprintf('locations/nearest?%s', http_build_query($params)))
            ->toArray();
dd($res);
        self::assertEquals(['test' => 'Hello world'], $res);
    }
}
