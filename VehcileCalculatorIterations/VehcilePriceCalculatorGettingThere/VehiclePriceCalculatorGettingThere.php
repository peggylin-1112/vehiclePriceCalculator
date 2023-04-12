<?php

declare(strict_types=1);

namespace VehcileCalculatorIterations\VehcilePriceCalculatorGettingThere;
use DateInterval;
use DateTimeImmutable;

class VehiclePriceCalculatorGettingThere
{
    public function __construct(
        private readonly float             $rrp,
        private readonly string            $damageCheckResult,
        private readonly DateTimeImmutable $lastMotDate,
        private readonly DateTimeImmutable $lastServiceDate,
    ) {
    }

    public function getPrice(): float
    {
        $price = $this->rrp;

        $price *= $this->getMotMultiplier();
        $price *= $this->getServiceMultiplier();
        $price *= $this->getDamageCheckMultiplier();

        return $price;
    }

    private function getMotMultiplier(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate < $this->lastMotDate->add(new DateInterval('P1Y'))) {
            return 0.25;
        }

        if ($currentDate < $this->lastMotDate->add(new DateInterval('P6M'))) {
            return 0.05;
        }

        return 1;
    }

    private function getServiceMultiplier(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P3Y'))) {
            return 0.3;
        }

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P1Y'))) {
            return 0.1;
        }

        if ($currentDate > $this->lastServiceDate->add(new DateInterval('P6M'))) {
            return 0.05;
        }

        return 1;
    }

    private function getDamageCheckMultiplier(): float
    {
        if ($this->damageCheckResult === 'Red') {
            return 0.9;
        }

        if ($this->damageCheckResult === 'Orange') {
            return 0.5;
        }

        return 1;
    }
}