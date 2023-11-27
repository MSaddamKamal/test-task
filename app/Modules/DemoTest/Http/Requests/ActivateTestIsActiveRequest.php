<?php

namespace App\Modules\DemoTest\Http\Requests;

use App\Modules\DemoTest\Models\DemoTest;
use Illuminate\Foundation\Http\FormRequest;

class ActivateTestIsActiveRequest extends UpdateTestIsActiveStatusRequest
{
    /**
     * @var string
     */
    protected $action = 'activated';

    /**
     * @var false
     */
    protected $status =  DemoTest::INACTIVE;
}
