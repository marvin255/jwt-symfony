<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\DependencyInjection;

use Marvin255\Jwt\Signer\Algorithm;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Object for bundle configurations.
 */
class Configuration implements ConfigurationInterface
{
    public const CONFIG_NAME = 'marvin255_jwt_symfony';

    /**
     * {@inheritdoc}
     *
     * @psalm-suppress UndefinedMethod
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::CONFIG_NAME);
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('profiles')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end()
                    ->defaultValue([])
                    ->prototype('array')
                    ->children()
                        ->booleanNode('use_expiration_constraint')
                            ->defaultValue(true)
                        ->end()
                        ->integerNode('expiration_leeway')
                            ->defaultValue(0)
                        ->end()
                        ->booleanNode('use_not_before_constraint')
                            ->defaultValue(true)
                        ->end()
                        ->integerNode('not_before_leeway')
                            ->defaultValue(0)
                        ->end()
                        ->booleanNode('use_audience_constraint')
                            ->defaultValue(false)
                        ->end()
                        ->scalarNode('audience')
                            ->defaultValue('')
                        ->end()
                        ->enumNode('signer')
                            ->values(Algorithm::ALL)
                        ->end()
                        ->scalarNode('signer_private')
                            ->defaultValue('')
                        ->end()
                        ->scalarNode('signer_public')
                            ->defaultValue('')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
