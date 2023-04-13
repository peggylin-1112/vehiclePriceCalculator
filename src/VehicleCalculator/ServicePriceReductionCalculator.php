<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\ValueObject\Vehicle;

class ServicePriceReductionCalculator implements ReductionCalculator
{
    private const VEHICLE_SERVICED_OVER_THREE_YEARS_AGO_REDUCTION_MULTIPLIER = 0.3;
    private const VEHICLE_SERVICED_BETWEEN_ONE_AND_THREE_YEARS_AGO_REDUCTION_MULTIPLIER = 0.1;
    private const VEHICLE_SERVICED_BETWEEN_SIX_MONTHS_AND_ONE_YEAR_AGO_REDUCTION_MULTIPLIER = 0.05;

    public function getPriceReduction(Vehicle $vehicle): float
    {
        $currentDate = new \DateTimeImmutable();
        $lastServiceDate = $vehicle->lastServiceDate;
        $vehicleRrp = $vehicle->rrp;

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