<?php

declare(strict_types=1);

namespace Tests\Hackathon\VehicleCalculator;

use Hackathon\VehicleCalculator\DamageCheckPricePriceReductionCalculator;
use Hackathon\VehicleCalculator\Enum\DamageCheckResult;
use Hackathon\VehicleCalculator\ValueObject\Vehicle;
use PHPUnit\Framework\TestCase;

class DamageCheckPriceReductionCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideDamageCheckValues
     */
    public function it_will_return_the_price_based_on_the_damage_check(float $rrp, DamageCheckResult $damageCheckResult, float $expectedPrice): void
    {
        $vehicle = new Vehicle(
            $rrp,
            $damageCheckResult,
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
        $newPrice = (new DamageCheckPricePriceReductionCalculator())->getPriceReduction($vehicle);

        $this->assertSame($expectedPrice, $newPrice);
    }

    /**
     * @return iterable<array{float, DamageCheckResult, float}>
     */
    public function provideDamageCheckValues(): iterable
    {
        yield 'Red' => [10_000.0, DamageCheckResult::Red, 9_000.0];
        yield 'Orange' => [10_000.0, DamageCheckResult::Orange, 5_000.0];
        yield 'Green' => [10_000.0, DamageCheckResult::Green, 0.0];
    }
}
