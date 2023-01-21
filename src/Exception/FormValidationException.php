<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use VolodymyrKlymniuk\ExceptionHandlerBundle\ExceptionHandlerMessages;

class FormValidationException extends HttpException implements FormValidationExceptionInterface
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * FormValidationException constructor.
     *
     * @param FormInterface $form
     * @param string        $message
     */
    public function __construct(FormInterface $form, string $message = ExceptionHandlerMessages::VALIDATION_ERROR)
    {
        $this->form = $form;

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}