<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use VolodymyrKlymniuk\ExceptionHandlerBundle\Handler\ExceptionHandlerResolver;

class ExceptionListener
{
    /**
     * @var ExceptionHandlerResolver
     */
    private $handlerResolver;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ExceptionHandlerResolver $handlerResolver
     * @param LoggerInterface          $logger
     */
    public function __construct(ExceptionHandlerResolver $handlerResolver, LoggerInterface $logger)
    {
        $this->handlerResolver = $handlerResolver;
        $this->logger = $logger;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        //get handler
        $handler = $this->handlerResolver->resolve($exception);

        $content = $handler->getBody($exception);
        $statucCode = $handler->getStatusCode($exception);
        $headers = $handler->getHeaders($exception);

        $event->setResponse(new JsonResponse($content, $statucCode, $headers));

        //log
        $f = FlattenException::create($exception);
        $this->logException($exception, sprintf('Exception thrown when handling an exception (%s: %s at %s line %s)', $f->getClass(), $f->getMessage(), $exception->getFile(), $exception->getLine()));
    }

    /**
     * Logs an exception.
     *
     * @param \Exception $exception The \Exception instance
     * @param string     $message   The error message to log
     */
    protected function logException(\Exception $exception, $message)
    {
        if (null !== $this->logger) {
            if (!$exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500) {
                $this->logger->critical($message, ['exception' => $exception]);
            } else {
                $this->logger->error($message, ['exception' => $exception]);
            }
        }
    }
}