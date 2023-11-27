<?php

namespace App\Modules\DemoTest\Helpers;

class RandomGenerator
{
    /**
     * @param int $min
     * @param int $max
     * @param int $quantity
     * @return array
     */
    public static function UniqueRandomNumbersWithinRange(int $min, int $max, int $quantity): array
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, (int)floor($quantity));
    }
}
