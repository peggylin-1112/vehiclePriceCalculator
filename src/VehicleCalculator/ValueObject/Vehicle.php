<?php

declare(strict_types=1);

namespace Hackathon\VehicleCalculator\ValueObject;

use Hackathon\VehicleCalculator\Enum\DamageCheckResult;

class Vehicle
{
    public function __construct(
        public readonly float $rrp,
        public readonly DamageCheckResult $damageCheckResult,
        public readonly \DateTimeImmutable $lastMotDate,
        public readonly \DateTimeImmutable $lastServiceDate,
    ) {}
}