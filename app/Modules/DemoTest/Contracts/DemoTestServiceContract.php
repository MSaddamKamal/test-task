<?php

namespace App\Modules\DemoTest\Contracts;

use App\Modules\DemoTest\DTO\Services\ActiveDeactiveTestDTO;
use App\Modules\DemoTest\Models\DemoTest;

interface DemoTestServiceContract
{
    /**
     * @param ActiveDeactiveTestDTO $data
     * @return DemoTest|null
     */
    public function activateTest(ActiveDeactiveTestDTO $data): ?DemoTest;

    /**
     * @param ActiveDeactiveTestDTO $data
     * @return DemoTest|null
     */
    public function deactivateTest(ActiveDeactiveTestDTO $data): ?DemoTest;

    /**
     * @return array
     */
    public function getAllInactiveRefs(): array;

    /**
     * @param string $ref
     * @return DemoTest|null
     */
    public function getTestByRef(string $ref): ?DemoTest;

    /**
     * @param array $payload
     * @param int $inquiryId
     * @return DemoTest|null
     */
    public function upsertTestAndIncrementInquiryCount(array $payload, int $inquiryId): ?DemoTest;

    /**
     * @param $ref
     * @param $data
     * @return DemoTest|null
     */
    public function updateOrCreateByRef($ref, $data): ?DemoTest;
}
