<?php

namespace App\Modules\DemoTest\Jobs;

use App\Modules\DemoTest\Contracts\DemoTestInquiryServiceContract;
use App\Modules\DemoTest\Services\DemoTestInquiryService;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Modules\DemoTest\Helpers\RandomGenerator;
use App\Modules\DemoTest\Models\DemoTestInquiry;


class ProcessDemoTestInquiryPayload implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const FAILED_PERCENTAGE = 10;

    /**
     * @var int
     */
    protected int $inquiryId;

    /**
     * @param int $inquiryId
     */
    public function __construct(int $inquiryId)
    {
        $this->inquiryId = $inquiryId;
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        // Get DemoTestingInquiryService from container
        $demoTestInquiryService = app(DemoTestInquiryService::class);
        $inquiry = $demoTestInquiryService->getInquiryById($this->inquiryId);

        Bus::batch($this->getBatchJobs($inquiry))->then(function (Batch $batch) use ($inquiry, $demoTestInquiryService) {
            // All jobs completed successfully...
            // Updating the inquiry status
            Log::info("Inquiry with id $inquiry->id is processed");
            $demoTestInquiryService->markInquiryAsProcessed($inquiry->id);
        })->catch(function (Batch $batch, \Throwable $e) use ($inquiry, $demoTestInquiryService) {
            // Batch job failure detected...
            // Updating the inquiry status
            Log::warning("Inquiry with id $inquiry->id is failed");
            $demoTestInquiryService->markInquiryAsFailed($inquiry->id);
        })->dispatch();

    }

    /**
     * @return bool
     */
    protected function shouldFailRandomly(): bool
    {
        // Checking if the environment variable or configuration flag is set
        return config('demotest.fail_jobs_randomly', false);
    }

    /**
     * @param int $itemsTotalCount
     * @return array
     */
    protected function randomJobIndexes(int $itemsTotalCount): array
    {
        // Calculating Required Failed Jobs
        $requiredFailedJobs = (static::FAILED_PERCENTAGE / 100) * $itemsTotalCount;

        $randomNumbers = [];
        if ($this->shouldFailRandomly()) {
            $randomNumbers = RandomGenerator::UniqueRandomNumbersWithinRange(0, $itemsTotalCount - 1, $requiredFailedJobs);
        }
        return $randomNumbers;
    }

    /**
     * @param DemoTestInquiry $inquiry
     * @return array
     */
    protected function getBatchJobs(DemoTestInquiry $inquiry): array
    {
        $jobs = [];
        $randomJobIndexes = $this->randomJobIndexes($inquiry->items_total_count);

        foreach ($inquiry->payload as $key => $payloadItem) {
            // if randomly generate numbers matches with index key then fail this job
            $fail = in_array($key, $randomJobIndexes);
            $jobs[] = new ProcessDemoTest($payloadItem, $inquiry->id, $fail);
        }

        return $jobs;
    }
}
