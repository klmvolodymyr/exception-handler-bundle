<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\Handler;

use Symfony\Component\Form\FormInterface;
use VolodymyrKlymniuk\ExceptionHandlerBundle\Exception\FormValidationException;
use VolodymyrKlymniuk\ExceptionHandlerBundle\Exception\FormValidationExceptionInterface;

class FormValidationHandler extends ExceptionHandler
{
    /**
     * {@inheritdoc}
     */
    public function supports(): string
    {
        return FormValidationExceptionInterface::class;
    }

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function getBody(\Exception $exception)
    {
        $data = parent::getBody($exception);
        /* @var $exception FormValidationException */
        $data['errors'] = $this->collectErrorsToArray($exception->getForm());

        return $data;
    }

    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    private function collectErrorsToArray(FormInterface $form)
    {
        $data = $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors = $error->getMessageTemplate();
        }

        if ($errors) {
            $data = $errors;
        }

        $children = [];
        foreach ($form->all() as $child) {
            /* @var $child FormInterface */
            $res = $this->collectErrorsToArray($child);
            if ($res !== []) {
                $children[$child->getName()] = $res;
            }
        }

        if ($children) {
            if (!is_array($data)) {
                $result[] = $data;
                $result += $children;

                return $result;
            } else {
                $data += $children;
            }
        }

        return $data;
    }
}