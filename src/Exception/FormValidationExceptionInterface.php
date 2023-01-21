<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Exception;

use Symfony\Component\Form\FormInterface;

interface FormValidationExceptionInterface
{
    /**
     * FormValidationException constructor.
     *
     * @param FormInterface $form
     * @param string        $message
     */
    public function __construct(FormInterface $form, string $message = ExceptionHandlerMessages::VALIDATION_ERROR);

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(): FormInterface;
}