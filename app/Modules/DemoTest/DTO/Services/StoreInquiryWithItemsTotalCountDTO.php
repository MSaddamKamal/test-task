<?php

namespace App\Modules\DemoTest\DTO\Services;

use Spatie\LaravelData\Data;

class StoreInquiryWithItemsTotalCountDTO extends Data
{
    public function __construct(
        public ?int $items_total_count,
        public array $payload
    ) {}
}
