<?php

class Currency
{
    protected string $code;
    protected float $exchangeRateToRub;

    public function __construct(string $code, float $exchangeRateToRub)
    {
        $this->code = $code;
        $this->exchangeRateToRub = $exchangeRateToRub;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getExchangeRateToRub(): float
    {
        return $this->exchangeRateToRub;
    }

    public function setExchangeRateToRub(float $exchangeRateToRub): void
    {
        $this->exchangeRateToRub = $exchangeRateToRub;
    }
}
