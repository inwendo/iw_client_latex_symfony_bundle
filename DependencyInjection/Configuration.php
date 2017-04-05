<?php

namespace Inwendo\LatexClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('inwendo_latex_client');

        $rootNode->children()
            ->scalarNode('endpoint')
            ->defaultValue('https://latex.service.inwendo.cloud')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('oauth_client_id')
            ->isRequired()
            ->defaultNull()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('oauth_client_secret')
            ->defaultNull()
            ->cannotBeEmpty()
            ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
