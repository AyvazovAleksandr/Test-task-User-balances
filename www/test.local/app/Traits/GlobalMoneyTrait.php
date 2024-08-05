<?php

namespace App\Traits;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Formatter\IntlMoneyFormatter;


trait GlobalMoneyTrait
{

    /**
     * Create Money Object
     *
     * @param float $amount
     * @param string $moneyCurrency
     * @return Money
     */
    public function createMoneyObject(float $amount, $moneyCurrency = 'USD'): Money
    {
        return new Money(bcmul($amount, 100), new Currency($moneyCurrency));
    }


    /**
     * Money formatter decimal
     *
     * @param Money $money
     * @return float
     */
    public function getMoneyDecimalFormat(Money $money): float
    {
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);
        return $moneyFormatter->format($money);
    }


    /**
     * Get money formatter
     * @param Money $money
     * @param string $numberFormatterCurrency
     * @return string
     */
    public function moneyFormatter(Money $money, string $numberFormatterCurrency = 'en_US'): string
    {
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($numberFormatterCurrency, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        return $moneyFormatter->format($money);
    }

    public function equalsMoneyDecimalFormat(float $first, float $second): bool
    {
        return $this->createMoneyObject($first)->equals($this->createMoneyObject($second));
    }



    public function getPaymentAmountFloatMoney(string|int|float $paymentAmount): float
    {
        return $this->getMoneyDecimalFormat($this->createMoneyObject($paymentAmount));
    }


    /**
     * Get money formatter
     * @param Money $money
     * @param string $numberFormatterCurrency
     * @return string
     */
    function getMoneyFormatter(Money $money, string $numberFormatterCurrency = 'en_US'): string
    {
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($numberFormatterCurrency, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        return $moneyFormatter->format($money);
    }
}
