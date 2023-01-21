<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Handler;

class ExceptionHandlerResolver
{
    /**
     * @var ExceptionHandlerInterface[]
     */
    private $handlers;

    /**
     * @param ExceptionHandlerInterface $handler
     */
    public function addExceptionHandler(ExceptionHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * @param \Throwable $e
     *
     * @return ExceptionHandlerInterface
     */
    public function resolve(\Throwable $e)
    {
        foreach ($this->handlers as $handler) {
            $supports = $handler->supports();
            if ($e instanceof $supports) {
                return $handler;
            }
        }

        return null;
    }
}