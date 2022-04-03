<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\LocationNearestFilterDto;
use App\Dto\Response\LocationDto;
use App\Repository\LocationRepository;
use App\Sdk\Rest\Configuration\MapperParamConverter;
use App\Sdk\Rest\Controller\RestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/locations")
 */
class LocationController extends RestController
{
    public function __construct(private LocationRepository $repository)
    {
    }

    /**
     * @Route("/nearest", methods={"GET"})
     * @MapperParamConverter("filter", class="App\Dto\Request\LocationNearestFilterDto")
     */
    public function nearest(LocationNearestFilterDto $filter): Response
    {
        $locations = $this->repository->findNearest($filter);

        return $this->createCollectionResponse($locations, LocationDto::class);
    }
}
