<?php


namespace Hexaequo\CurrencyConverterBundle;


use Hexaequo\CurrencyConverterBundle\DependencyInjection\Compiler\CurrencyConverterProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CurrencyConverterBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CurrencyConverterProviderCompilerPass());
    }

}