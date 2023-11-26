<?php

namespace App\Modules\DemoTest\Services;

use App\Modules\DemoTest\Contracts\DemoTestServiceContract;
use App\Modules\DemoTest\DTO\Services\ActiveDeactiveTestDTO;
use App\Modules\DemoTest\Models\DemoTest;
use App\Modules\DemoTest\Repositories\DemoTestRepository;

class DemoTestService implements DemoTestServiceContract
{
    /**
     * @var DemoTestRepository
     */
    protected DemoTestRepository $repository;

    /**
     * @param DemoTestRepository $repository
     */
    public function __construct(DemoTestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ActiveDeactiveTestDTO $data
     * @return DemoTest|null
     */
    public function activateTest(ActiveDeactiveTestDTO $data): ?DemoTest
    {
        if($record = $this->getTestByRef($data->ref)) {
            return $this->repository->update($record->id, ['is_active' => DemoTest::ACTIVE]);
        };
        return null;
    }

    /**
     * @param ActiveDeactiveTestDTO $data
     * @return DemoTest|null
     */
    public function deactivateTest(ActiveDeactiveTestDTO $data): ?DemoTest
    {
        if($record = $this->getTestByRef($data->ref)) {
            return $this->repository->update($record->id, ['is_active' => DemoTest::INACTIVE]);
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAllInactiveRefs(): array
    {
        return $this->repository->getAllInactiveRefs();
    }

    /**
     * @param string $ref
     * @return DemoTest|null
     */
    public function getTestByRef(string $ref): ?DemoTest
    {
        return $this->repository->findByRef($ref);
    }

    /**
     * @param array $payload
     * @param int $inquiryId
     * @return DemoTest|null
     */
    public function upsertTestAndIncrementInquiryCount(array $payload, int $inquiryId): ?DemoTest
    {
        $record = $this->updateOrCreateByRef($payload['ref'], $payload);
        app(DemoTestInquiryService::class)->incrementProcessedCount($inquiryId);
        return $record;
    }

    /**
     * @param $ref
     * @param $data
     * @return DemoTest|null
     */
    public function updateOrCreateByRef($ref, $data): ?DemoTest
    {
        $recordExist = $this->repository->findByRef($ref);

        if ($recordExist) {
            // update
            return $this->repository->update($recordExist->id, array_merge($data, ['status' => DemoTest::UPDATE_STATUS]));
        }

        return $this->repository->create(array_merge($data, ['status' => DemoTest::CREATE_STATUS]));
    }

}
