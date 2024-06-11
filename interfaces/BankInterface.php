<?php

interface BankInterface
{
    public function openNewAccount(string $primaryCurrency): BankAccount;
    public function changeExchangeRate(Currency $currency, float $newRate): void;
    public function convertBalance(BankAccount $account, string $fromCurrency, string $toCurrency, float $amount): void;
    public function disableCurrency(BankAccount $account, string $currencyCode): void;
}
