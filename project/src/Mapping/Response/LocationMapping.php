<?php

declare(strict_types=1);

namespace App\Mapping\Response;

use App\Dto\Response\LocationDto;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\DataType;

class LocationMapping implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(DataType::ARRAY, LocationDto::class)
            ->forMember('lon', fn(array $data) => $data['location_geo'][0] ?? null)
            ->forMember('lat', fn(array $data) => $data['location_geo'][1] ?? null);
    }
}
