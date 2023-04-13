<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\Enum\DamageCheckResult;

class VehiclePriceCalculator
{
    public function __construct(
        private readonly MotPriceReductionCalculator $motPriceReductionCalculator,
        private readonly ServicePriceReductionCalculator $servicePriceReductionCalculator,
        private readonly DamageCheckPriceReductionCalculator $damageCheckPriceReductionCalculator,
    ) {}

    public function getPrice(
        float $rrp,
        DamageCheckResult $damageCheckResult,
        \DateTimeImmutable $lastMotDate,
        \DateTimeImmutable $lastServiceDate,
    ): float
    {
        if ($rrp <= 0) {
            return 0.0;
        }

        $price = $rrp
            - $this->motPriceReductionCalculator->getPriceReduction($lastMotDate, $rrp)
            - $this->servicePriceReductionCalculator->getPriceReduction($lastServiceDate, $rrp)
            - $this->damageCheckPriceReductionCalculator->getPriceReduction($damageCheckResult, $rrp);

        return $price > 0 ? $price : 0.0;
    }
}