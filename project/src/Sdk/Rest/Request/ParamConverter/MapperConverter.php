<?php

declare(strict_types=1);

namespace App\Sdk\Rest\Request\ParamConverter;

use App\Sdk\ExceptionHandler\Exception\ValidationException;
use App\Sdk\Rest\Configuration\MapperParamConverter;
use App\Sdk\Rest\Request\RequestMapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MapperConverter implements ParamConverterInterface
{
    public function __construct(private RequestMapper $mapper, private ValidatorInterface $validator)
    {
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        if (!$configuration instanceof MapperParamConverter) {
            throw new \RuntimeException(sprintf(
                '"%s" should be instance of MapperParamConverter',
                get_class($configuration)
            ));
        }

        $dto = $this->mapper->map($request, $configuration->getClass());

        /** @var ConstraintViolationList $errors */
        $errors = $this->validator->validate($dto, null, $configuration->getValidationGroups());
        if (count($errors) > 0) {
            throw new ValidationException((array)$errors->getIterator());
        }

        $request->attributes->set($configuration->getName(), $dto);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration instanceof MapperParamConverter;
    }
}
