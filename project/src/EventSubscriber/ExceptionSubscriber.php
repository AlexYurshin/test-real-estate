<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolation;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException'],
            ],
        ];
    }

    public function processException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof ValidationException) {
            return; // @todo handle exceptions
        }

        $content = [];
        foreach ($throwable->getErrors() as $error) {
            if ($error instanceof ConstraintViolation) {
                $content[$error->getPropertyPath()][] = $error->getMessage();
            }
        }

        $event->setResponse(new JsonResponse(
            ['errors' => $content],
            $throwable->getStatusCode(),
            $throwable->getHeaders()
        ));
    }
}
