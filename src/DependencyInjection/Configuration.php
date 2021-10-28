<?php

namespace Matt\SyCaptchaBundle\DependencyInjection;

/**
 * Defines the configuration file scheme and loads it into active configuration
 */
class Configuration implements \Symfony\Component\Config\Definition\ConfigurationInterface
{
    public function getConfigTreeBuilder(): \Symfony\Component\Config\Definition\Builder\TreeBuilder
    {
        $treeBuilder = new \Symfony\Component\Config\Definition\Builder\TreeBuilder('sy_captcha');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('sy_captcha'); //Layer for Symfony 4.1 and older
        }

        $rootNode->children()
            ->booleanNode('enabled')
                ->defaultTrue()
                ->end()
            ->arrayNode('recaptcha_v2')
                ->children()
                    ->scalarNode('site_key')
                        ->defaultNull()
                        ->end()
                    ->scalarNode('secret_key')
                        ->defaultNull()
                        ->end()
                    ->scalarNode('api_host')
                        ->defaultValue('www.google.com')
                        ->end()
                ->end()
            ->end()
            ->arrayNode('recaptcha_v3')
                ->children()
                    ->scalarNode('site_key')
                        ->defaultNull()
                        ->end()
                    ->scalarNode('secret_key')
                        ->defaultNull()
                        ->end()
                    ->scalarNode('api_host')
                        ->defaultValue('www.google.com')
                        ->end()
                    ->floatNode('score_threshold')
                        ->min(0.1)
                        ->max(1.0)
                        ->defaultValue(0.5)
                        ->end()
                ->end()
            ->end()
            ->arrayNode('hcaptcha')
                ->children()
                    ->scalarNode('site_key')
                        ->defaultNull()
                        ->end()
                    ->scalarNode('secret_key')
                        ->defaultNull()
                        ->end()
                    ->scalarNode('api_host')
                        ->defaultValue('js.hcaptcha.com')
                        ->end()
                    ->booleanNode('invisible')
                        ->defaultValue(false)
                        ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}