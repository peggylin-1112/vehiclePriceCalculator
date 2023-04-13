<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\Enum\DamageCheckResult;
use Hackathon\VehicleCalculator\ValueObject\Vehicle;

class DamageCheckPriceReductionCalculator implements ReductionCalculator
{
    private const RED_REDUCTION_MULTIPLIER = 0.9;
    private const ORANGE_REDUCTION_MULTIPLIER = 0.5;

    public function getPriceReduction(Vehicle $vehicle): float
    {
        return match ($vehicle->damageCheckResult) {
            DamageCheckResult::Red => $vehicle->rrp * self::RED_REDUCTION_MULTIPLIER,
            DamageCheckResult::Orange => $vehicle->rrp * self::ORANGE_REDUCTION_MULTIPLIER,
            DamageCheckResult::Green => 0.0,
        };
    }
}