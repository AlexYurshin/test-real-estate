<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\LocationNearestFilter;
use App\Sdk\Rest\Controller\RestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/locations")
 */
class LocationController extends RestController
{
    /**
     * @Route("/nearest", methods={"GET"})
     */
    public function nearest(LocationNearestFilter $filter): Response
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        return new Response(json_encode(['test' => 'Hello world']), Response::HTTP_OK, $headers);
    }
}
