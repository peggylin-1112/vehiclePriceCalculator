<?php

declare(strict_types=1);

class VehiclePriceCalculator
{
    public function __construct(
        private readonly float $rrp,
    ) {
    }

    public function getPrice(): float
    {
        return $this->rrp;
    }
}