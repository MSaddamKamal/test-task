<?php

namespace App\Modules\DemoTest\Services;

use App\Modules\DemoTest\Contracts\DemoTestInquiryServiceContract;
use App\Modules\DemoTest\DTO\Services\StoreInquiryWithItemsTotalCountDTO;
use App\Modules\DemoTest\Jobs\ProcessDemoTestInquiryPayload;
use App\Modules\DemoTest\Models\DemoTestInquiry;
use App\Modules\DemoTest\Repositories\DemoTestInquiryRepository;

class DemoTestInquiryService implements DemoTestInquiryServiceContract
{
    /**
     * @var DemoTestInquiryRepository
     */
    protected DemoTestInquiryRepository $repository;

    /**
     * @param DemoTestInquiryRepository $repository
     */
    public function __construct(DemoTestInquiryRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param int $id
     * @return DemoTestInquiry|null
     */
    public function getInquiryById(int $id): ?DemoTestInquiry
    {
        return $this->repository->findById($id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function incrementFailedCount(int $id): int
    {
        return $this->repository->incrementCount($id, DemoTestInquiry::FAILED_COUNT_COLUMN);
    }

    /**
     * @param int $id
     * @return int
     */
    public function incrementProcessedCount(int $id): int
    {
        return $this->repository->incrementCount($id, DemoTestInquiry::PROCESSED_COUNT_COLUMN);
    }

    /**
     * @param int $id
     * @return DemoTestInquiry|null
     */
    public function markInquiryAsFailed(int $id): ?DemoTestInquiry
    {
        return $this->repository->update($id, ['status' => DemoTestInquiry::STATUS_FAILED]);
    }

    /**
     * @param int $id
     * @return DemoTestInquiry|null
     */
    public function markInquiryAsProcessed(int $id): ?DemoTestInquiry
    {
        return $this->repository->update($id, ['status' => DemoTestInquiry::STATUS_PROCESSED]);
    }

    /**
     * @param StoreInquiryWithItemsTotalCountDTO $data
     * @return bool
     */
    public function storeInquiryWithItemsTotalCount(StoreInquiryWithItemsTotalCountDTO $data): bool
    {
        $data->items_total_count = count($data->payload);
        if ($inquiry = $this->repository->create($data->toArray())) {
            ProcessDemoTestInquiryPayload::dispatch($inquiry->id);
            return true;
        }
        return false;
    }
}
