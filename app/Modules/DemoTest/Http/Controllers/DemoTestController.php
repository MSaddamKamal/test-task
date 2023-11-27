<?php

namespace App\Modules\DemoTest\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DemoTest\Contracts\DemoTestServiceContract;
use App\Modules\DemoTest\DTO\Services\ActiveDeactiveTestDTO;
use App\Modules\DemoTest\Http\Requests\ActivateTestIsActiveRequest;
use App\Modules\DemoTest\Http\Requests\DeactivateTestIsActiveRequest;
use App\Modules\DemoTest\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class DemoTestController extends Controller
{
    /**
     * @var DemoTestServiceContract
     */
    protected DemoTestServiceContract $demoTestService;

    /**
     * @param DemoTestServiceContract $demoTestService
     */
    public function __construct(DemoTestServiceContract $demoTestService)
    {
        $this->demoTestService = $demoTestService;
    }

    /**
     * Activate Test
     *
     * This endpoint is used to activate a test.
     *
     * @urlParam ref string required needs to be exist in the database and the record  must be inactive priorly.
     * Example: T-2
     *
     * @response 200 scenario="success"
     * {
     *      "success": true,
     *      "data": {
     *           "id": 2,
     *           "ref": "T-2",
     *           "name": "test",
     *           "description": "Test description",
     *           "status": "NEW",
     *           "is_active": 1,
     *           "created_at": "2023-11-26T16:30:02.000000Z",
     *           "updated_at": "2023-11-26T20:29:21.000000Z"
     *      },
     *      "message": "Test activated successfully"
     *  }
     *
     * @response 422 scenario="Some Validation Error || ref in db found with status already active || Other Exception"
     * {
     *    "success": false,
     *    "data": null,
     *    "message": "The test either does not exist or already activated."
     * }
     *
     * @param ActivateTestIsActiveRequest $request
     * @return JsonResponse
     */
    public function activateTest(ActivateTestIsActiveRequest $request): JsonResponse
    {
        $record = $this->demoTestService->activateTest(ActiveDeactiveTestDTO::from($request->validated()));
        return ApiResponse::response(
            records: $record,
            message: trans('demotest::messages.isActive_status', ['status' => 'activated'])
        );
    }

    /**
     * Deactivate Test
     *
     * This endpoint is used to deactivate a test.
     *
     * @urlParam ref string required needs to be exist in the database and the record  must be active priorly.
     * Example: T-2
     *
     * @response 200 scenario="success"
     * {
     *     "success": true,
     *     "data": {
     *          "id": 2,
     *          "ref": "T-2",
     *          "name": "test",
     *          "description": "Test description",
     *          "status": "NEW",
     *          "is_active": 0,
     *          "created_at": "2023-11-26T16:30:02.000000Z",
     *          "updated_at": "2023-11-26T20:29:21.000000Z"
     *     },
     *     "message": "Test deactivated successfully"
     * }
     *
     * @response 422 scenario="Some Validation Error || ref in db found with status already inactive || Other Exception"
     *  {
     *     "success": false,
     *     "data": null,
     *     "message": "The test either does not exist or already deactivated."
     *  }
     *
     * @param DeactivateTestIsActiveRequest $request
     * @return JsonResponse
     */
    public function deactivateTest(DeactivateTestIsActiveRequest $request): JsonResponse
    {
        $record = $this->demoTestService->deactivateTest(ActiveDeactiveTestDTO::from($request->validated()));
        return ApiResponse::response(
            records: $record,
            message: trans('demotest::messages.isActive_status', ['status' => 'deactivated'])
        );
    }
}
