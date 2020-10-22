<?php

namespace App\EventListener;

use App\Exception\PrivateException;
use App\Exception\PublicException;
use App\Response\ErrorResponse;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SerializerInterface
     */
    private $serializer;


    /**
     * ExceptionListener constructor.
     *
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger) {
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event) {
        $exception = $event->getThrowable();

        $httpResponse = new Response();

        $jsendData = new ErrorResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $jsendData->setMessage($exception->getMessage());

            $httpResponse->headers->replace($exception->getHeaders());

        } elseif ($exception instanceof PrivateException) {
            $this->logger->log(LogLevel::INFO, $exception->getMessage());

            $jsendData->setMessage(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);

            $httpResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        } elseif ($exception instanceof PublicException) {
            $jsendData->setMessage($exception->getMessage());

            $httpResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $this->logger->log(LogLevel::INFO, $exception->getMessage());

            // set default message and error number 500
            $jsendData->setMessage(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);
            $httpResponse->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Customize your httpResponse object to display the exception details
        $json = $this->serializer->serialize($jsendData, 'json');
        $httpResponse->setContent($json);

        // sends the modified httpResponse object to the event
        $event->setResponse($httpResponse);
    }
}
