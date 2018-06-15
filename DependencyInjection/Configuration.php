<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('generator_extended');
        $rootNode
            ->children()
                ->booleanNode('ask_use_datatable')
                    ->defaultTrue()
                ->end()
                ->booleanNode('use_datatable_default')
                    ->defaultTrue()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
