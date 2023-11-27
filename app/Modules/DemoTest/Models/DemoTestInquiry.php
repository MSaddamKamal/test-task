<?php

namespace App\Modules\DemoTest\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoTestInquiry extends Model
{
    use HasFactory;

    const STATUS_FAILED = 'FAILED';
    const STATUS_PROCESSED = 'PROCESSED';
    const STATUS_ACTIVE = 'ACTIVE';
    const FAILED_COUNT_COLUMN = 'items_failed_count';
    const PROCESSED_COUNT_COLUMN = 'items_processed_count';

    /**
     * @var string
     */
    protected $table = 'demo_test_inquiry';
    /**
     * @var string[]
     */
    protected $fillable = ['payload','items_total_count','status'];

    /**
     * @var string[]
     */
    protected $casts = [
        'payload' => 'array',
    ];
}
