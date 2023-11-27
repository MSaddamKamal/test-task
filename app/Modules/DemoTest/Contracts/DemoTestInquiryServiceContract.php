<?php

namespace App\Modules\DemoTest\Contracts;

use App\Modules\DemoTest\DTO\Services\StoreInquiryWithItemsTotalCountDTO;
use App\Modules\DemoTest\Models\DemoTestInquiry;

interface DemoTestInquiryServiceContract
{
    /**
     * @param int $id
     * @return DemoTestInquiry|null
     */
    public function getInquiryById(int $id): ?DemoTestInquiry;

    /**
     * @param int $id
     * @return int
     */
    public function incrementFailedCount(int $id): int;

    /**
     * @param int $id
     * @return int
     */
    public function incrementProcessedCount(int $id): int;

    /**
     * @param int $id
     * @return DemoTestInquiry|null
     */
    public function markInquiryAsFailed(int $id): ?DemoTestInquiry;

    /**
     * @param int $id
     * @return DemoTestInquiry|null
     */
    public function markInquiryAsProcessed(int $id): ?DemoTestInquiry;

    /**
     * @param StoreInquiryWithItemsTotalCountDTO $data
     * @return bool
     */
    public function storeInquiryWithItemsTotalCount(StoreInquiryWithItemsTotalCountDTO $data): bool;
}
