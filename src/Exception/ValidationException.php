<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use VolodymyrKlymniuk\ExceptionHandlerBundle\ExceptionHandlerMessages;

class ValidationException extends HttpException implements ValidationExceptionInterface
{
    /**
     * @var array
     */
    private $errors;

    /**
     * ValidationException constructor.
     *
     * @param array   $errors
     * @param string  $message
     */
    public function __construct(array $errors, string $message = ExceptionHandlerMessages::VALIDATION_ERROR)
    {
        $this->errors = $errors;

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}