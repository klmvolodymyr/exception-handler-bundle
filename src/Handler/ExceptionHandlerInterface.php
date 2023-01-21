<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Handler;

interface ExceptionHandlerInterface
{
    /**
     * @return string
     */
    public function supports(): string;

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function getBody(\Exception $exception);

    /**
     * Extracts status code from the exception
     *
     * @param \Exception $exception
     *
     * @return int
     */
    public function getStatusCode(\Exception $exception): int;

    /**
     * Extracts headers from the exception
     *
     * @param \Exception $exception
     *
     * @return array
     */
    public function getHeaders(\Exception $exception): array;
}