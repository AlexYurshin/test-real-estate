<?php

declare(strict_types=1);

namespace App\Tests\JsonSchema;

class LocationSchema
{
    public static function getItemJsonSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'name' => [
                    'type' => 'string',
                ],
                'type' => [
                    'type' => 'string',
                ],
                'lon' => [
                    'type' => 'number',
                ],
                'lat' => [
                    'type' => 'number',
                ],
            ],
            'required' => [
                'name',
                'type',
                'lon',
                'lat',
            ]
        ];
    }

    public static function getCollectionJsonSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => self::getItemJsonSchema(),
                ],
            ],
        ];
    }
}
