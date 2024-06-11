<?php

require_once 'interfaces/BankInterface.php';

class Bank implements BankInterface
{
    public function openNewAccount(string $primaryCurrency): BankAccount
    {
        return new BankAccount($primaryCurrency);
    }

    public function changeExchangeRate(Currency $currency, float $newRate): void
    {
        $currency->setExchangeRateToRub($newRate);
    }

    public function convertBalance(BankAccount $account, string $fromCurrency, string $toCurrency, float $amount): void
    {
        $convertedAmount = round($account->convertBalance($fromCurrency, $toCurrency, $amount));
        $account->withdraw($fromCurrency, $amount);
        $account->deposit($toCurrency, $convertedAmount);
    }

    public function disableCurrency(BankAccount $account, string $currencyCode): void
    {
        unset($account->currencies[$currencyCode]);
        unset($account->balances[$currencyCode]);
    }
}
