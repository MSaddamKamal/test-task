<?php

namespace App\Modules\DemoTest\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DemoTest\Contracts\DemoTestInquiryServiceContract;
use App\Modules\DemoTest\DTO\Services\StoreInquiryWithItemsTotalCountDTO;
use App\Modules\DemoTest\Http\Requests\StoreTestInquiryRequest;
use App\Modules\DemoTest\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DemoTestInquiryController extends Controller
{
    /**
     * @var DemoTestInquiryServiceContract
     */
    protected DemoTestInquiryServiceContract $service;

    /**
     * @param DemoTestInquiryServiceContract $service
     */
    public function __construct(DemoTestInquiryServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Store Demo Test Inquiry Payload
     *
     * This endpoint is used to store a test inquiry payload to the system
     * and then schedule a job to insert test payload items in the system.
     *
     * @bodyParam payload object[] required needs the ref and name for each array item while description is optional.
     * Example: [
     *  {
     *      "ref": "T-1",
     *      "name": "test",
     *      "description": null
     *  },
     *  {
     *      "ref": "T-2",
     *      "name": "test",
     *      "description": "Test description"
     *  }
     * ]
     *
     * @response 201 scenario="success" {
     *  "success": true,
     *  "data": null,
     *  "message": "Successfully Scheduled"
     * }
     *
     * @response 422 scenario="Some Validation Error || ref in db found with status inactive || Other Exception"{
     *   "success": false,
     *   "data": null,
     *   "message": "some error msg"
     * }
     *
     * @param StoreTestInquiryRequest $request
     * @return JsonResponse
     */
    public function store(StoreTestInquiryRequest $request): JsonResponse
    {
        $storeInquiryDTO = StoreInquiryWithItemsTotalCountDTO::from($request->validated());
        $this->service->storeInquiryWithItemsTotalCount($storeInquiryDTO);
        return ApiResponse::response(
            message: trans('demotest::messages.scheduled'),
            statusCode: Response::HTTP_CREATED
        );
    }
}
