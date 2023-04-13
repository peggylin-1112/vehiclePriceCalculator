<?php

declare(strict_types=1);

namespace Tests\Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\DamageCheckPriceReductionCalculator;
use Hackathon\VehicleCalculator\Enum\DamageCheckResult;
use Hackathon\VehicleCalculator\MotPriceReductionCalculator;
use Hackathon\VehicleCalculator\ServicePriceReductionCalculator;
use Hackathon\VehicleCalculator\ValueObject\Vehicle;
use PHPUnit\Framework\TestCase;

class ServicePriceReductionCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideDamageCheckValues
     */
    public function it_will_return_the_price_based_on_how_long_ago_was_the_cars_last_service(float $rrp, \DateTimeImmutable $lastServiceDate, float $expectedPrice): void
    {
        $vehicle = new Vehicle(
            $rrp,
            DamageCheckResult::Green,
            new \DateTimeImmutable(),
            $lastServiceDate,
        );

        $newPrice = (new ServicePriceReductionCalculator())->getPriceReduction($vehicle);

        $this->assertSame($expectedPrice, $newPrice);
    }

    /**
     * @return iterable<array{float, \DateTimeImmutable, float}>
     */
    public function provideDamageCheckValues(): iterable
    {
        yield 'Over 3 year ago' => [10_000.0, new \DateTimeImmutable('2019-09-01 00:00:00'), 3_000.0];
        yield 'Between 1 and 3 years ago' => [10_000.0, new \DateTimeImmutable('2021-09-01 00:00:00'), 1_000.0];
        yield 'Between 6 months and a year ago' => [10_000.0, new \DateTimeImmutable('2022-08-01 00:00:00'), 500.0];
        yield 'Within 6 months' => [10_000.0, new \DateTimeImmutable('2023-01-01 00:00:00'), 0.0];
    }
}
