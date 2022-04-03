<?php

declare(strict_types=1);

namespace App\Dictionary;

class LocationTypeDictionary
{
    public const CITY = 'city';

    public static function getAllowedValues(): array
    {
        return [
            self::CITY,
        ];
    }
}
