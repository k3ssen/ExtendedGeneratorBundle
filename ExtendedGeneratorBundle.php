<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle;

use K3ssen\ExtendedGeneratorBundle\DependencyInjection\Compiler\ExtendedGeneratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExtendedGeneratorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ExtendedGeneratorCompilerPass());
    }
}
