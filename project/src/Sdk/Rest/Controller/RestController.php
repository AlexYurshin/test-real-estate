<?php

declare(strict_types=1);

namespace App\Sdk\Rest\Controller;

use AutoMapperPlus\AutoMapperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class RestController extends AbstractController
{
    protected AutoMapperInterface $mapper;
    protected SerializerInterface $serializer;

    /**
     * @required
     */
    public function setMapper(AutoMapperInterface $mapper): self
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @required
     */
    public function setSerializer(SerializerInterface $serializer): self
    {
        $this->serializer = $serializer;

        return $this;
    }

    protected function createResponse($data, ?string $targetClass = null, int $statusCode = Response::HTTP_OK): Response
    {
        if (null !== $targetClass) {
            $data = $this->mapper->map($data, $targetClass);
        }

        $data = $this->serializer->serialize($data, 'json');

        $headers = [
            'Content-Type' => 'application/json',
        ];

        return new Response($data, $statusCode, $headers);
    }

    protected function createCollectionResponse(iterable $collection, string $targetClass = null): Response
    {
        $items = array_values($collection instanceof \Traversable ? iterator_to_array($collection) : $collection);
        $items = empty($targetClass) ? $items : $this->mapper->mapMultiple($items, $targetClass);

        return $this->createResponse(['items' => $items]);
    }
}
