<?php

namespace App\Modules\DemoTest\Http\Requests;

use App\Modules\DemoTest\Models\DemoTest;
use Illuminate\Foundation\Http\FormRequest;

class DeactivateTestIsActiveRequest extends UpdateTestIsActiveStatusRequest
{
    /**
     * @var string
     */
    protected $action = 'deactivated';

    /**
     * @var true
     */
    protected $status = DemoTest::ACTIVE;
}
