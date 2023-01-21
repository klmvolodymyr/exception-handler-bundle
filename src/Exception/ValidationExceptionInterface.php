<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Exception;

use Symfony\Component\Form\FormInterface;

interface ValidationExceptionInterface
{
    /**
     * ValidationException constructor.
     *
     * @param array  $errors
     * @param string $message
     */
    public function __construct(array $errors, string $message = ExceptionHandlerMessages::VALIDATION_ERROR);

    /**
     * @return array
     */
    public function getErrors(): array;
}