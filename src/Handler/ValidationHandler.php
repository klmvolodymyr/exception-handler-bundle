<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Handler;

use Symfony\Component\Validator\ConstraintViolation;
use VolodymyrKlymniuk\ExceptionHandlerBundle\Exception\ValidationException;
use VolodymyrKlymniuk\ExceptionHandlerBundle\Exception\ValidationExceptionInterface;

class ValidationHandler extends ExceptionHandler
{
    /**
     * {@inheritdoc}
     */
    public function supports(): string
    {
        return ValidationExceptionInterface::class;
    }

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function getBody(\Exception $exception)
    {
        $data = parent::getBody($exception);

        /* @var $exception ValidationException */
        $data['errors'] = $this->collectErrorsToArray($exception->getErrors());

        return $data;
    }

    /**
     * @param array $errors
     *
     * @return mixed
     */
    private function collectErrorsToArray(array $errors)
    {
        $data = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $field = strtolower(preg_replace('/[A-Z]/', '_\\0', $error->getPropertyPath()));
            if (!array_key_exists($field, $data)) {
                $data[$field] = [];
            }
            $data[$field][] = $error->getMessage();
        }

        return $data;
    }
}
