<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Handler;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use VolodymyrKlymniuk\ExceptionHandlerBundle\ExceptionHandlerMessages;

class ExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @param bool $debug
     */
    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(): string
    {
        return \Throwable::class;
    }

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function getBody(\Exception $exception)
    {
        $statusCode = $this->getStatusCode($exception);

        $body = [
            'code'    => $statusCode,
            'message' => $this->getExceptionMessage($exception, $statusCode),
        ];

        if (true === $this->debug) {
            $body['exception'] = [
                'message' => $exception->getMessage(),
                'class'   => get_class($exception),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTrace(),
            ];
        }

        return $body;
    }

    /**
     * Extracts status code from the exception
     *
     * @param \Exception $exception
     *
     * @return int
     */
    public function getStatusCode(\Exception $exception): int
    {
        return $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * Extracts headers from the exception
     *
     * @param \Exception $exception
     *
     * @return array
     */
    public function getHeaders(\Exception $exception): array
    {
        return $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : [];
    }

    /**
     * Extracts the exception message.
     *
     * @param \Exception $exception
     * @param int|null   $statusCode
     *
     * @return string
     */
    protected function getExceptionMessage(\Exception $exception, int $statusCode = null): string
    {
        $message = (string) $exception->getMessage();
        if ('' === $message && $statusCode == Response::HTTP_FORBIDDEN) {
            $message = ExceptionHandlerMessages::ACCESS_DENIED;
        }

        if ('' === $message && $statusCode >= 500) {
            $message = ExceptionHandlerMessages::INTERNAL_ERROR;
        }

        return $message;
    }
}