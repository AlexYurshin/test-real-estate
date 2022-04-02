<?php

declare(strict_types=1);

namespace App\Sdk\Rest\Request;

use AutoMapperPlus\AutoMapperInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestMapper
{
    public function __construct(private AutoMapperInterface $mapper)
    {
    }

    public function map(Request $request, string $targetClass)
    {
        $parameters = \array_merge(
            $request->attributes->get('_route_params', []),
            $request->query->all('filter') ?? []
        );

        // @todo implement Filter mapper converter

        return $this->mapper->map($parameters, $targetClass);
    }
}
