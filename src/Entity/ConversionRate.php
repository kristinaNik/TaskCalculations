<?php

declare(strict_types=1);

namespace App\Entity;

class ConversionRate
{
    private string $currencyFrom;

    private string $currencyTo;

    private string $rate;

    public function setCurrencyFrom(string $currencyFrom): self
    {
        $this->currencyFrom = $currencyFrom;
        return $this;
    }

    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }

    public function setCurrencyTo(string $currencyTo): self
    {
        $this->currencyTo = $currencyTo;
        return $this;
    }

    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function getRate(): string
    {
        return $this->rate;
    }
}
