<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

class ServicePriceReductionCalculator
{
    private const VEHICLE_SERVICED_OVER_THREE_YEARS_AGO_REDUCTION_MULTIPLIER = 0.3;
    private const VEHICLE_SERVICED_BETWEEN_ONE_AND_THREE_YEARS_AGO_REDUCTION_MULTIPLIER = 0.1;
    private const VEHICLE_SERVICED_BETWEEN_SIX_MONTHS_AND_ONE_YEAR_AGO_REDUCTION_MULTIPLIER = 0.05;

    public function getPriceReduction(\DateTimeImmutable $lastServiceDate, float $vehicleRrp): float
    {
        $currentDate = new \DateTimeImmutable();

        if ($currentDate > $lastServiceDate->add(new \DateInterval('P3Y'))) {
            return $vehicleRrp * self::VEHICLE_SERVICED_OVER_THREE_YEARS_AGO_REDUCTION_MULTIPLIER;
        }

        if ($currentDate >= $lastServiceDate->add(new \DateInterval('P1Y'))) {
            return $vehicleRrp * self::VEHICLE_SERVICED_BETWEEN_ONE_AND_THREE_YEARS_AGO_REDUCTION_MULTIPLIER;
        }

        if ($currentDate >= $lastServiceDate->add(new \DateInterval('P6M'))) {
            return $vehicleRrp * self::VEHICLE_SERVICED_BETWEEN_SIX_MONTHS_AND_ONE_YEAR_AGO_REDUCTION_MULTIPLIER;
        }

        return 0.0;
    }
}