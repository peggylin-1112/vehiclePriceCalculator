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
        $price -= $this->getMotReduction();
        $price -= $this->getServiceReduction();
        $price -= $this->getDamageCheckReduction();

        return max($price, 0);
    }

    private function getMotReduction(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastMotDate->add(new DateInterval('P1Y'))) {
            return $this->rrp * 0.25;
        }

        if ($currentDate > $this->lastMotDate->add(new DateInterval('P6M'))) {
            return $this->rrp * 0.05;
        }

        return 0;
    }

    private function getServiceReduction(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P3Y'))) {
            return $this->rrp * 0.3;
        }

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P1Y'))) {
            return $this->rrp * 0.1;
        }

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P6M'))) {
            return $this->rrp * 0.05;
        }

        return 0;
    }

    private function getDamageCheckReduction(): float
    {
        if ($this->damageCheckResult === 'Red') {
            return $this->rrp * 0.9;
        }

        if ($this->damageCheckResult === 'Orange') {
            return $this->rrp * 0.5;
        }

        return 0;
    }
}