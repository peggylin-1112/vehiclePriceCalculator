<?php

declare(strict_types=1);

namespace Tests\Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\DamageCheckPriceReductionCalculator;
use Hackathon\VehicleCalculator\Enum\DamageCheckResult;
use Hackathon\VehicleCalculator\MotPriceReductionCalculator;
use Hackathon\VehicleCalculator\ValueObject\Vehicle;
use PHPUnit\Framework\TestCase;

class MotPriceReductionCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideDamageCheckValues
     */
    public function it_will_return_the_price_based_on_how_long_is_left_on_the_cars_mot(float $rrp, \DateTimeImmutable $lastMotDate, float $expectedPrice): void
    {
        $vehicle = new Vehicle(
            $rrp,
            DamageCheckResult::Green,
            $lastMotDate,
            new \DateTimeImmutable(),
        );

        $newPrice = (new MotPriceReductionCalculator())->getPriceReduction($vehicle);

        $this->assertSame($expectedPrice, $newPrice);
    }

    /**
     * @return iterable<array{float, \DateTimeImmutable, float}>
     */
    public function provideDamageCheckValues(): iterable
    {
        yield 'Over 1 year ago' => [10_000.0, new \DateTimeImmutable('2021-09-01 00:00:00'), 2_500.0];
        yield 'Between 6 months and a year ago' => [10_000.0, new \DateTimeImmutable('2022-08-01 00:00:00'), 500.0];
        yield 'Within 6 months' => [10_000.0, new \DateTimeImmutable('2023-01-01 00:00:00'), 0.0];
    }
}
