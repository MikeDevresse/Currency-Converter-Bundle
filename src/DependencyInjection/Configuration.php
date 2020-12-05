<?php


namespace Hexaequo\CurrencyConverterBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {

        $treeBuilder = new TreeBuilder('currency_converter');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }

}