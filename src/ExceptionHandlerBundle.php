<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VolodymyrKlymniuk\ExceptionHandlerBundle\DependencyInjection\Compiler\ExceptionHandlerPass;

class ExceptionHandlerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ExceptionHandlerPass());
    }
}