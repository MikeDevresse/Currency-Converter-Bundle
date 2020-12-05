<?php


namespace Hexaequo\CurrencyConverterBundle\Provider;


use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class CoinbaseProvider extends AbstractProvider
{
    public static function getDefaultPriority(): int
    {
        return 0;
    }

    public function support(string $in, string $out): bool
    {
        $cache = new FilesystemAdapter();

        $allowedCurrencies = $cache->get('coinbase_currencies',function(ItemInterface $item){
            $item->expiresAfter(3600);

            $response = $this->client->request(
                'GET',
                'https://api.coinbase.com/v2/exchange-rates'
            )->toArray();
            if(isset($response['data']) and isset($response['data']['rates'])) {
                return array_keys($response['data']['rates']);
            }
            return [];
        });

        return in_array($in,$allowedCurrencies) and in_array($out,$allowedCurrencies);
    }

    public function getRate(string $in, string $out): float
    {
        $cache = new FilesystemAdapter();

        $rate = $cache->get('coinbase_rate_'.$in.'_'.$out,function(ItemInterface $item) use ($in,$out) {
            $item->expiresAfter(15);

            $response = $this->client->request(
                'GET',
                'https://api.coinbase.com/v2/exchange-rates',
                ['query'=> ['currency'=>$in]]
            )->toArray();

            if ($response['data'] and $response['data']['rates'] and $response['data']['rates'][$out])
                return $response['data']['rates'][$out];

            throw new \Exception('Unable to get response from provider ' . self::class);
        });

        return $rate;
    }

}