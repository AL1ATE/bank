<?php

require_once 'Currency.php';

class BankAccount
{
    public string $primaryCurrency;
    public array $currencies = [];
    public array $balances = [];

    public function __construct(string $primaryCurrency)
    {
        $this->primaryCurrency = $primaryCurrency;
    }

    public function addCurrency(Currency $currency): void
    {
        $this->currencies[$currency->getCode()] = $currency;
        $this->balances[$currency->getCode()] = 0;
    }

    public function setPrimaryCurrency(string $currencyCode): void
    {
        if (isset($this->currencies[$currencyCode])) {
            $this->primaryCurrency = $currencyCode;
        } else {
            echo "Валюта $currencyCode не поддерживается.\n";
        }
    }

    public function getSupportedCurrencies(): array
    {
        return array_keys($this->currencies);
    }

    public function deposit(string $currencyCode, float $amount): void
    {
        if (isset($this->currencies[$currencyCode])) {
            $this->balances[$currencyCode] += $amount;
        }
    }

    public function withdraw(string $currencyCode, float $amount): void
    {
        if (isset($this->currencies[$currencyCode])) {
            if ($this->balances[$currencyCode] >= $amount) {
                $this->balances[$currencyCode] -= $amount;
            } else {
                echo "Недостаточно баланса в $currencyCode\n";
            }
        }
    }

    public function getBalance(string $currencyCode = ''): float
    {
        if ($currencyCode === '') {
            $currencyCode = $this->primaryCurrency;
        }

        if (isset($this->currencies[$currencyCode])) {
            return $this->balances[$currencyCode];
        }

        return 0;
    }

    public function convertBalance(string $fromCurrency, string $toCurrency, float $amount): float
    {
        if (!isset($this->currencies[$fromCurrency]) || !isset($this->currencies[$toCurrency])) {
            return 0;
        }

        $fromRate = $this->currencies[$fromCurrency]->getExchangeRateToRub();
        $toRate = $this->currencies[$toCurrency]->getExchangeRateToRub();

        return $amount * $fromRate / $toRate;
    }
}
