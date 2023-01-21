<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use VolodymyrKlymniuk\ExceptionHandlerBundle\Handler\ExceptionHandlerResolver;

class ExceptionHandlerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $handlers = [];
        $resolver = $container->getDefinition(ExceptionHandlerResolver::class);

        foreach ($container->findTaggedServiceIds('exception_handler') as $id => $tags) {
            $handlers[$id] = $tags[0]['priority'] ?? 0;
        }

        uasort($handlers, function ($priority1, $priority2) {
            return $priority1 < $priority2;
        });

        //add to scenario calculator
        foreach (array_keys($handlers) as $handlerId) {
            $resolver->addMethodCall('addExceptionHandler', [$container->getDefinition($handlerId)]);
        }
    }
}