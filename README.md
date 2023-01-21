# Exception Handler Bundle #

## About #

The Exception Handler Bundle helps to catch and process output for different types of exceptions

## Installation ##

Require the bundle and its dependencies with composer:

```bash
$ composer require volodymyr-klymniuk/exception-handler-bundle
```

Register the bundle:
```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        ...
        new ExceptionHandlerBundle\ExceptionHandlerBundle(),
    );
}
```

## Handle form validation ##
```php
    <?php
    $form = $this->formFactory->create($formType, $data);
    
    $form->submit($request->request->all());
    if (!$form->isValid()) {
        throw new FormValidationException($form);
    }
```