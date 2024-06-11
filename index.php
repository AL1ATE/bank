<?php

require_once 'classes/Currency.php';
require_once 'classes/BankAccount.php';
require_once 'classes/Bank.php';

$bank = new Bank();

// Создание счета и пополнение
$account = $bank->openNewAccount('RUB');
$rub = new Currency('RUB', 1);
$eur = new Currency('EUR', 80);
$usd = new Currency('USD', 70);
$account->addCurrency($rub);
$account->addCurrency($eur);
$account->addCurrency($usd);

echo "Поддерживаемые валюты: " . implode(", ", $account->getSupportedCurrencies()) . "\n";

$account->deposit('RUB', 1000);
$account->deposit('EUR', 50);
$account->deposit('USD', 40);

echo "Баланс в RUB: " . $account->getBalance('RUB') . "\n";
echo "Баланс в USD: " . $account->getBalance('USD') . "\n";
echo "Баланс в EUR: " . $account->getBalance('EUR') . "\n";

// Пополнение и списание
$account->deposit('RUB', 1000);
$account->deposit('EUR', 50);
$account->withdraw('USD', 10);

// Изменение курса валюты
$bank->changeExchangeRate($eur, 150);
$bank->changeExchangeRate($usd, 100);
echo "Баланс после изменения курса: " . $account->getBalance('RUB') . " RUB\n";

// Изменение основной валюты
$account->setPrimaryCurrency('EUR');
echo "Баланс в EUR: " . $account->getBalance() . " EUR\n";

// Конвертация
$amount = $account->getBalance('RUB');
$bank->convertBalance($account, 'RUB', 'EUR', $amount);
echo "Баланс после конвертации: " . $account->getBalance('EUR') . " EUR\n";

// Изменение курса EUR
$bank->changeExchangeRate($eur, 120);
echo "Баланс после изменения курса: " . $account->getBalance() . " EUR\n";

// Отключение валют
$account->setPrimaryCurrency('RUB');
$bank->disableCurrency($account, 'EUR');
$bank->disableCurrency($account, 'USD');
echo "Поддерживаемые валюты: " . implode(", ", $account->getSupportedCurrencies()) . "\n";
echo "Баланс после отключения валют: " . $account->getBalance() . " RUB\n";
