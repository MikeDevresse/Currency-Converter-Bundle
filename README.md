# Currency-Converter-Bundle


## What is it

This bundle allows you to convert currencies and crypto currencies with providers that you can customize. This is made for Symfony !! By default there is two providers, Coinbase and Bitpay, you can add your own by extending the AbstractProvider class.

## Installation

In order to install this bundle run : composer require hexaequo/currency-converter-bundle

## Usage

You can use this bundle by auto-wiring the Hexaequo\CurrencyConverterBundle\Converter service and using the convert method.

For example: 
```PHP

use Hexaequo\CurrencyConverterBundle\Converter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyController extends AbstractController
{
  public function myPage(Converter $converter) {
    $euroValue = $converter->convert(1.5,'BTC','EUR');
    // At the time I'm writting it this will be equal to: 23650,85
  }
  
}  
  
```

Based on the providers that you implement you can convert any currencies based on what is supported.

## Support me 

![bitcoin](https://img.shields.io/badge/Bitcoin-344NM3oDRrRPfiXTE3UHXC9wQfcMdRczUb-green)
