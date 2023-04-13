<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\Enum\DamageCheckResult;
use Hackathon\VehicleCalculator\ValueObject\Vehicle;

class VehiclePriceCalculator
{
    public function __construct(
        private readonly MotPricePriceReductionCalculator         $motPriceReductionCalculator,
        private readonly ServicePricePriceReductionCalculator     $servicePriceReductionCalculator,
        private readonly DamageCheckPricePriceReductionCalculator $damageCheckPriceReductionCalculator,
    ) {}

    public function getPrice(Vehicle $vehicle): float
    {
        if ($vehicle->rrp <= 0) {
            return 0.0;
        }

        $price = $vehicle->rrp
            - $this->motPriceReductionCalculator->getPriceReduction($vehicle)
            - $this->servicePriceReductionCalculator->getPriceReduction($vehicle)
            - $this->damageCheckPriceReductionCalculator->getPriceReduction($vehicle);

        return $price > 0 ? $price : 0.0;
    }
}