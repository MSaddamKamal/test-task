<?php

namespace App\Modules\DemoTest\DTO\Services;

use Spatie\LaravelData\Data;

class ActiveDeactiveTestDTO extends Data
{
    public function __construct(
        public string $ref
    ) {}
}
