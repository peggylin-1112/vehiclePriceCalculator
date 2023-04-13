<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\ValueObject\Vehicle;

class MotPricePriceReductionCalculator implements PriceReductionCalculator
{
    private const EXPIRED_MOT_REDUCTION_MULTIPLIER = 0.25;
    private const MOT_EXPIRING_WITHIN_SIX_MONTHS_REDUCTION_MULTIPLIER = 0.05;

    public function getPriceReduction(Vehicle $vehicle): float
    {
        $currentDate = new \DateTimeImmutable();
        $lastMotDate = $vehicle->lastMotDate;
        $vehicleRrp = $vehicle->rrp;

        if ($currentDate > $lastMotDate->add(new \DateInterval('P1Y'))) {
            return $vehicleRrp * self::EXPIRED_MOT_REDUCTION_MULTIPLIER;
        }

        if ($currentDate > $lastMotDate->add(new \DateInterval('P6M'))) {
            return $vehicleRrp * self::MOT_EXPIRING_WITHIN_SIX_MONTHS_REDUCTION_MULTIPLIER;
        }

        return 0.0;
    }
}