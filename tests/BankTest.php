<?php

require_once 'classes/Currency.php';
require_once 'classes/BankAccount.php';
require_once 'classes/Bank.php';

use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    public function testOpenNewAccount()
    {
        $bank = new Bank();
        $account = $bank->openNewAccount('RUB');

        $this->assertInstanceOf(BankAccount::class, $account);
        $this->assertEquals('RUB', $account->primaryCurrency);
    }

    public function testChangeExchangeRate()
    {
        $bank = new Bank();
        $eur = new Currency('EUR', 80);
        $bank->changeExchangeRate($eur, 150);

        $this->assertEquals(150, $eur->getExchangeRateToRub());
    }

    public function testConvertBalance()
    {
        $bank = new Bank();
        $account = new BankAccount('RUB');
        $eur = new Currency('EUR', 80);
        $usd = new Currency('USD', 70);
        $account->addCurrency($eur);
        $account->addCurrency($usd);

        $account->deposit('EUR', 100);
        $account->deposit('USD', 100);

        $bank->convertBalance($account, 'EUR', 'USD', 80);

        $this->assertEquals(20, $account->getBalance('EUR'));
        $this->assertEquals(191, $account->getBalance('USD'));
    }

    public function testDisableCurrency()
    {
        $bank = new Bank();
        $account = new BankAccount('RUB');
        $eur = new Currency('EUR', 80);
        $usd = new Currency('USD', 70);
        $account->addCurrency($eur);
        $account->addCurrency($usd);

        $bank->disableCurrency($account, 'EUR');

        $this->assertArrayNotHasKey('EUR', $account->currencies);
        $this->assertArrayNotHasKey('EUR', $account->balances);
    }
}
