<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

class MotPriceReductionCalculator
{
    private const EXPIRED_MOT_REDUCTION_MULTIPLIER = 0.25;
    private const MOT_EXPIRING_WITHIN_SIX_MONTHS_REDUCTION_MULTIPLIER = 0.05;

    public function getPriceReduction(\DateTimeImmutable $lastMotDate, float $vehicleRrp): float
    {
        $currentDate = new \DateTimeImmutable();

        if ($currentDate > $lastMotDate->add(new \DateInterval('P1Y'))) {
            return $vehicleRrp * self::EXPIRED_MOT_REDUCTION_MULTIPLIER;
        }

        if ($currentDate > $lastMotDate->add(new \DateInterval('P6M'))) {
            return $vehicleRrp * self::MOT_EXPIRING_WITHIN_SIX_MONTHS_REDUCTION_MULTIPLIER;
        }

        return 0.0;
    }
}