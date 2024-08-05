<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        $responseBody = [
            'message'       => $exception->getMessage(),
            'code'          => $exception->getCode(),
        ];
        if ($exception instanceof ApiException) {
            $responseBody['errors'] = $exception->getDetails();
        }
        $response = new JsonResponse($responseBody);

//        if ($exception instanceof HttpExceptionInterface) {
//            $response->setStatusCode($exception->getStatusCode());
//            $response->headers->replace($exception->getHeaders());
//        } else {
//            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
//        }

//        $event->setResponse($response);


//        if ('application/json' === $request->headers->get('Content-Type')) {
//            $response = new JsonResponse([
//                'message'       => $exception->getMessage(),
//                'code'          => $exception->getCode()
//            ]);
//
            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
//
            $event->setResponse($response);
//        }
    }
}

