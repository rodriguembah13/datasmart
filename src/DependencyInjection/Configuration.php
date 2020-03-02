<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DependencyInjection;

use App\Entity\User;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class validates and merges configuration from the files:
 * - config/packages/kimai.yaml
 * - config/packages/local.yaml.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('gest');
        /** @var ArrayNodeDefinition $node */
        $node = $treeBuilder->getRootNode();

        $node
            ->children()
                ->append($this->getInvoiceNode())
                ->append($this->getLanguagesNode())
                ->append($this->getPermissionsNode())
            ->end()
        ->end();

        return $treeBuilder;
    }

    protected function getInvoiceNode()
    {
        $builder = new TreeBuilder('invoice');
        /** @var ArrayNodeDefinition $node */
        $node = $builder->getRootNode();

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('defaults')
                    ->scalarPrototype()->end()
                    ->defaultValue([
                        'var/invoices/',
                        'templates/invoice/renderer/',
                    ])
                ->end()
                ->arrayNode('documents')
                    ->requiresAtLeastOneElement()
                    ->scalarPrototype()->end()
                    ->defaultValue([])
                ->end()
            ->end()
        ;

        return $node;
    }
    protected function getPermissionsNode()
    {
        $builder = new TreeBuilder('permissions');
        /** @var ArrayNodeDefinition $node */
        $node = $builder->getRootNode();

        $node
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('sets')
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('key')
            ->arrayPrototype()
            ->useAttributeAsKey('key')
            ->isRequired()
            ->scalarPrototype()->end()
            ->defaultValue([])
            ->end()
            ->end()
            ->arrayNode('maps')
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('key')
            ->arrayPrototype()
            ->useAttributeAsKey('key')
            ->isRequired()
            ->scalarPrototype()->end()
            ->defaultValue([])
            ->end()
            ->end()
            ->arrayNode('roles')
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('key')
            ->arrayPrototype()
            ->isRequired()
            ->scalarPrototype()->end()
            ->defaultValue([])
            ->end()
            ->defaultValue([
                'ROLE_USER' => [],
                'ROLE_TEAMLEAD' => [],
                'ROLE_ADMIN' => [],
                'ROLE_SUPER_ADMIN' => [],
            ])
            ->end()
            ->end()
        ;

        return $node;
    }
    protected function getLanguagesNode()
    {
        $builder = new TreeBuilder('languages');
        /** @var ArrayNodeDefinition $node */
        $node = $builder->getRootNode();

        $node
            ->useAttributeAsKey('name', false) // see https://github.com/symfony/symfony/issues/18988
            ->arrayPrototype()
                ->children()
                    ->scalarNode('date_time_type')->defaultValue('yyyy-MM-dd HH:mm')->end()     // for DateTimeType
                    ->scalarNode('date_type')->defaultValue('yyyy-MM-dd')->end()                // for DateType
                    ->scalarNode('date')->defaultValue('Y-m-d')->end()                          // for display via twig
                    ->scalarNode('date_time')->defaultValue('m-d H:i')->end()                   // for display via twig
                    ->scalarNode('duration')->defaultValue('%%h:%%m h')->end()                  // for display via twig
                    ->scalarNode('time')->defaultValue('H:i')->end()                            // for display via twig
                    ->booleanNode('24_hours')->defaultTrue()->end()                             // for DateTimeType JS component
                ->end()
            ->end()
        ;

        return $node;
    }

    protected function getDefaultsNode()
    {
        $builder = new TreeBuilder('defaults');
        /** @var ArrayNodeDefinition $node */
        $node = $builder->getRootNode();

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('customer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('timezone')->defaultNull()->end()
                        ->scalarNode('country')->defaultValue('DE')->end()
                        ->scalarNode('currency')->defaultValue(Customer::DEFAULT_CURRENCY)->end()
                    ->end()
                ->end()
                ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('timezone')->defaultNull()->end()
                        ->scalarNode('language')->defaultValue(User::DEFAULT_LANGUAGE)->end()
                        ->scalarNode('theme')->defaultNull()->end()
                        ->scalarNode('currency')->defaultValue(Customer::DEFAULT_CURRENCY)->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
