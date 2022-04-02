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
        $config->registerMapping(DataType::ARRAY, LocationDto::class);
    }
}
