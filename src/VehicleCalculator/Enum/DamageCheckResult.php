<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator\Enum;

enum DamageCheckResult
{
    case Green;
    case Orange;
    case Red;
}