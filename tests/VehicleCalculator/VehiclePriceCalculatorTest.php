<?php

declare(strict_types=1);

namespace Tests\Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\DamageCheckPriceReductionCalculator;
use Hackathon\VehicleCalculator\Enum\DamageCheckResult;
use Hackathon\VehicleCalculator\MotPriceReductionCalculator;
use Hackathon\VehicleCalculator\ServicePriceReductionCalculator;
use Hackathon\VehicleCalculator\ValueObject\Vehicle;
use Hackathon\VehicleCalculator\VehiclePriceCalculator;
use PHPUnit\Framework\TestCase;

class VehiclePriceCalculatorTest extends TestCase
{
    private VehiclePriceCalculator $fixture;

    protected function setup(): void
    {
        $this->fixture = new VehiclePriceCalculator(
            new MotPriceReductionCalculator(),
            new ServicePriceReductionCalculator(),
            new DamageCheckPriceReductionCalculator(),
        );
    }

    /**
     * @test
     * @dataProvider provideVehicleInformation
     */
    public function it_will_return_the_price_based_on_the_damage_check(float $rrp, \DateTimeImmutable $lastMotDate, \DateTimeImmutable $lastServiceDate, DamageCheckResult $damageCheckResult, float $expectedPrice): void
    {
        $vehicle = new Vehicle(
            $rrp,
            $damageCheckResult,
            $lastMotDate,
            $lastServiceDate,
        );

        $price = $this->fixture->getPrice($vehicle);

        $this->assertSame($expectedPrice, $price);
    }

    /**
     * @return iterable<array{float, \DateTimeImmutable, \DateTimeImmutable, DamageCheckResult, float}>
     */
    public function provideVehicleInformation(): iterable
    {
        yield [0.0, new \DateTimeImmutable('2023-03-01 00:00:00'), new \DateTimeImmutable('2023-03-01 00:00:00'), DamageCheckResult::Green, 0.0];
        yield [10_000.0, new \DateTimeImmutable('2021-09-01 00:00:00'), new \DateTimeImmutable('2023-02-01 00:00:00'), DamageCheckResult::Orange, 2_500.0];
        yield [10_000.0, new \DateTimeImmutable('2021-09-01 00:00:00'), new \DateTimeImmutable('2023-02-01 00:00:00'), DamageCheckResult::Red, 0.0];
    }
}
