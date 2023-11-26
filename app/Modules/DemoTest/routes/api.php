<?php

use Illuminate\Support\Facades\Route;
use App\Modules\DemoTest\Http\Controllers\DemoTestInquiryController;
use App\Modules\DemoTest\Http\Controllers\DemoTestController;


Route::group(['prefix' => 'api'], function () {
    // Create Test Inquiry Route
    Route::post('demo/test', [DemoTestInquiryController::class, 'store']);
    // Activation/Deactivation Routes
    Route::post('demo/test/activate/{ref}', [DemoTestController::class, 'activateTest']);
    Route::post('demo/test/deactivate/{ref}', [DemoTestController::class, 'deactivateTest']);
});
