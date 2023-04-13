<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\ValueObject\Vehicle;

interface ReductionCalculator
{
    public function getPriceReduction(Vehicle $vehicle): float;
}