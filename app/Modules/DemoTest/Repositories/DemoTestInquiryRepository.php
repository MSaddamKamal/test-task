<?php

namespace App\Modules\DemoTest\Repositories;

use App\Modules\DemoTest\Models\DemoTestInquiry;

class DemoTestInquiryRepository extends BaseRepository
{
    /**
     * @var DemoTestInquiry
     */
    public DemoTestInquiry $model;

    /**
     * @param DemoTestInquiry $model
     */
    public function __construct(DemoTestInquiry $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @param $column
     * @return int
     */
    public function incrementCount($id, $column): int
    {
        return $this->findById($id)?->increment($column) ?? 0;
    }
}
