<?php

declare(strict_types=1);

namespace App\Dto\Response;

class LocationDto
{
    public string $name;

    public string $type;

    public float $lat;

    public float $lon;
}
