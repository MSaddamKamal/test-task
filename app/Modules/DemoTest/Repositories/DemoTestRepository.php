<?php

namespace App\Modules\DemoTest\Repositories;

use App\Modules\DemoTest\Models\DemoTest;

class DemoTestRepository extends BaseRepository
{
    /**
     * @var DemoTest
     */
    protected DemoTest $model;

    /**
     * @param DemoTest $model
     */
    public function __construct(DemoTest $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $ref
     * @return DemoTest|null
     */
    public function findByRef(string $ref): ?DemoTest
    {
        return $this->model->where('ref', $ref)->first();
    }

    /**
     * @return array
     */
    public function getAllInactiveRefs(): array
    {
        return $this->model->where('is_active', DemoTest::INACTIVE)->pluck('ref')->toArray();
    }

}
