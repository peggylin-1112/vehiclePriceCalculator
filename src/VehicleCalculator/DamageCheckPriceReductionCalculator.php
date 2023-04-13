<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\Enum\DamageCheckResult;

class DamageCheckPriceReductionCalculator
{
    private const RED_REDUCTION_MULTIPLIER = 0.9;
    private const ORANGE_REDUCTION_MULTIPLIER = 0.5;

    public function getPriceReduction(DamageCheckResult $result, float $price): float
    {
        return match ($result) {
            DamageCheckResult::Red => $price * self::RED_REDUCTION_MULTIPLIER,
            DamageCheckResult::Orange => $price * self::ORANGE_REDUCTION_MULTIPLIER,
            DamageCheckResult::Green => 0.0,
        };
    }
}