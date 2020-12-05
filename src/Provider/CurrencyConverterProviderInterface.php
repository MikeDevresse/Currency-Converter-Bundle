<?php


namespace Hexaequo\CurrencyConverterBundle\Provider;


interface CurrencyConverterProviderInterface {
    public function support(string $in, string $out): bool;

    public function getRate(string $in, string $out): ?float;
}