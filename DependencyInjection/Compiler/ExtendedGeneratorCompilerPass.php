<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ExtendedGeneratorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Replaces the Generator CrudCommand by the ExtendedGenerator CrudCommand
        $definition = $container->getDefinition(\K3ssen\GeneratorBundle\Command\CrudCommand::class);
        $definition->setClass(\K3ssen\ExtendedGeneratorBundle\Command\CrudCommand::class);
    }
}