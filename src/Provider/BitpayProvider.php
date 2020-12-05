<?php


namespace Hexaequo\CurrencyConverterBundle\Provider;


use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitpayProvider extends AbstractProvider
{
    protected array $allowedIn = ['BTC','BCH'];

    protected array $allowedOut = [];

    public static function getDefaultPriority(): int
    {
        return 0;
    }

    public function support(string $in, string $out): bool
    {
        $this->allowedOut = self::$FIAT_CURRENCIES;
        return parent::support($in, $out);
    }

    public function getRate(string $in, string $out): float {

        $cache = new FilesystemAdapter();

        $rate = $cache->get('bitpay_rate_'.$in.'_'.$out,function(ItemInterface $item) use ($in,$out) {
            $item->expiresAfter(15);


            $response = $this->client->request(
                'GET',
                sprintf('https://bitpay.com/rates/%s/%s',$in,$out)
            )->toArray();

            if ($response['data'] and $response['data']['rate'])
                return $response['data']['rate'];

            throw new \Exception('Unable to get response from provider ' . self::class);
        });
        return $rate;
    }

}