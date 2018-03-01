<?php

namespace Tequila\Bundle\SwaggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('tequila_swagger')
            ->children()
                ->arrayNode('allowed_path_patterns')
                    ->info('List of regex patterns to document endpoints that match them.')
                    ->example(['^/api'])
                    ->prototype('scalar')->end()
                    ->defaultValue(['/docs/swagger'])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
