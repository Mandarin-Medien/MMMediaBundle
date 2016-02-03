<?php

namespace MandarinMedien\MMMediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mm_media');

        $this->addMediaTypesSection($rootNode);
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }

    private function addMediaTypesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('media_types')
                    ->children()
                        ->arrayNode('types')
                        ->prototype('scalar')->end()
                        ->defaultValue(array(
                            'MandarinMedien\\MMMediaBundle\\MediaType\\ImageMediaType',
                            'MandarinMedien\\MMMediaBundle\\MediaType\\FileMediaType',
                            'MandarinMedien\\MMMediaBundle\\MediaType\\VideoMediaType',
                            'MandarinMedien\\MMMediaBundle\\MediaType\\YoutubeMediaType',
                            'MandarinMedien\\MMMediaBundle\\MediaType\\VimeoMediaType',
                        ))
                        ->end()
//                      ->arrayNode('allowed')
//                          ->prototype('array')
//                              ->defaultValue(array())
//                          ->end()
//                      ->end()
                    ->end()
                ->end()
            ->end();
    }
}
