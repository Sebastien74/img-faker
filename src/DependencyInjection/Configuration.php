<?php

namespace FakeImgBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration definition
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Build configuration tree
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('seb_fake_img');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('route_prefix')
            ->defaultValue('/placeholder')
            ->end()
            ->scalarNode('background_color')
            ->defaultValue('e0e0e0')
            ->end()
            ->scalarNode('text_color')
            ->defaultValue('707070')
            ->end()
            ->integerNode('max_width')
            ->defaultValue(4000)
            ->end()
            ->integerNode('max_height')
            ->defaultValue(4000)
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}