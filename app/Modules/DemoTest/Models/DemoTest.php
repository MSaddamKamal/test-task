<?php

namespace App\Modules\DemoTest\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoTest extends Model
{
    use HasFactory;

    const ACTIVE = true;
    const INACTIVE = false;
    const UPDATE_STATUS = 'UPDATED';
    const CREATE_STATUS = 'NEW';

    /**
     * @var string
     */
    protected $table = 'demo_test';
    
    /**
     * @var string[]
     */
    protected $fillable = ['ref','name','description','status','is_active'];
}
