<?php

declare(strict_types=1);

class VehiclePriceCalculatorFinalFinal
{
    public function __construct(
        private readonly float $rrp,
        private readonly string $damageCheckResult,
        private readonly DateTimeImmutable $lastMotDate,
        private readonly DateTimeImmutable $lastServiceDate,
    ) {}

    public function getPrice(): float
    {
        $price = $this->rrp;
        $price -= $this->rrp * $this->getMotMultiplier();
        $price -= $this->rrp * $this->getServiceMultiplier();
        $price -= $this->rrp * $this->getDamageCheckMultiplier();

        return max($price, 0);
    }

    private function getMotMultiplier(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastMotDate->add(new DateInterval('P1Y'))) {
            return 0.75;
        }

        if ($currentDate > $this->lastMotDate->add(new DateInterval('P6M'))) {
            return 0.95;
        }

        return 1;
    }

    private function getServiceMultiplier(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P3Y'))) {
            return 0.7;
        }

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P1Y'))) {
            return 0.9;
        }

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P6M'))) {
            return 0.95;
        }

        return 1;
    }

    private function getDamageCheckMultiplier(): float
    {
        if ($this->damageCheckResult === 'Red') {
            return  0.1;
        }

        if ($this->damageCheckResult === 'Orange') {
            return  0.5;
        }

        return 1;
    }
}