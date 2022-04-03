<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    public function __construct(private iterable $errors)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST);
    }

    public function getErrors(): iterable
    {
        return $this->errors;
    }
}
