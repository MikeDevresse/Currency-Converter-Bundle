<?php


namespace Hexaequo\CurrencyConverterBundle\DependencyInjection;


use Hexaequo\CurrencyConverterBundle\Provider\CurrencyConverterProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class CurrencyConverterExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');


        $container->registerForAutoconfiguration(CurrencyConverterProviderInterface::class)
            ->addTag('currency_converter_provider');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('currency_converter.converter');
    }

}