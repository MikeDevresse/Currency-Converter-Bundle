<?php

namespace Hexaequo\CurrencyConverterBundle;

use Hexaequo\CurrencyConverterBundle\Provider\CurrencyConverterProviderInterface;

class Converter {

    /**
     * @var iterable $providers
     */
    private iterable $providers;

    public function __construct(iterable $providers)
    {

        $this->providers = $providers;
    }

    public function convert(float $amount, string $in, string $out): ?float {
        /** @var CurrencyConverterProviderInterface $provider */
        $rate = null;
        foreach ($this->providers as $provider) {
            if($provider->support($in,$out)) {
                try {
                    $rate = $provider->getRate($in,$out);
                    break;
                }
                catch (\Exception $e){}
            }
        }
        if ($rate) {
            return round($amount * $rate, 7);
        }
        foreach ($this->providers as $provider) {
            if($provider->support($out,$in)) {
                try {
                    $rate = $provider->getRate($out,$in);
                    break;
                }
                catch (\Exception $e){}
            }
        }
        if ($rate) {
            return round($amount / $rate, 7);
        }

        return null;
    }
}