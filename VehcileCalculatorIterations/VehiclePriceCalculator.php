<?php

declare(strict_types=1);

class VehiclePriceCalculator
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
        return $this->rrp
            - $this->getMotMultiplier()
            - $this->getServiceMultiplier()
            - $this->getDamageCheckMultiplier();
    }

    private function getMotMultiplier(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastMotDate->add(new \DateInterval('P1Y'))) {
            return $this->rrp * 0.25;
        }

        if ($currentDate > $this->lastMotDate->add(new \DateInterval('P6M'))) {
            return $this->rrp * 0.05;
        }

        return 0.0;
    }

    private function getServiceMultiplier(): float
    {
        $currentDate = new DateTimeImmutable();

        if ($currentDate > $this->lastServiceDate->add(new \DateInterval('P3Y'))) {
            return $this->rrp * 0.3;
        }

        if ($currentDate >= $this->lastServiceDate->add(new \DateInterval('P1Y'))) {
            return $this->rrp * 0.1;
        }

        if ($currentDate >= $this->lastServiceDate->add(new \DateInterval('P6M'))) {
            return $this->rrp * 0.05;
        }

        return 0.0;
    }

    private function getDamageCheckMultiplier(): float
    {
        return match ($this->damageCheckResult) {
            'Red' => $this->rrp * 0.9,
            'Orange' => $this->rrp * 0.5,
            default => 0.0,
        };
    }
}