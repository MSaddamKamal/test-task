<?php

namespace App\Modules\DemoTest\Jobs;

use App\Modules\DemoTest\Services\DemoTestInquiryService;
use App\Modules\DemoTest\Services\DemoTestService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ProcessDemoTest implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $tries = 2;
    /**
     * @var array
     */
    protected array $payloadItem;
    /**
     * @var int
     */
    protected int $inquiryId;
    /**
     * @var bool
     */
    protected bool $intentionallyFail;

    /**
     * @param array $payloadItem
     * @param int $inquiryId
     * @param bool $intentionallyFail
     */
    public function __construct(array $payloadItem, int $inquiryId, bool $intentionallyFail = false)
    {
        $this->payloadItem = $payloadItem;
        $this->inquiryId = $inquiryId;
        $this->intentionallyFail = $intentionallyFail;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            // check if intentionallyFail is true
            if($this->intentionallyFail){
                $this->fail('Job Failed');
                throw new \Exception('Failed');
            }
            app(DemoTestService::class)->upsertTestAndIncrementInquiryCount($this->payloadItem,$this->inquiryId);

        } catch (\Exception $e) {
            // Checking if this is the final attempt
            if ($this->attempts() == $this->tries) {
                // Incrementing failed count in the inquiry
                app(DemoTestInquiryService::class)->incrementFailedCount($this->inquiryId);
                throw $e;
            }

            $this->release();

        }
    }

}

