<?php

namespace App\Modules\DemoTest\Rules;

use App\Modules\DemoTest\Services\DemoTestService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DuplicateInactiveRefsRule implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $demoTestService = app(DemoTestService::class);
        // Check for existing records with is_active = false
        $inactiveRefs = $demoTestService->getAllInactiveRefs() ?? [];
        $duplicateRefs = array_intersect($inactiveRefs, array_column($value, 'ref'));

        if(!empty($duplicateRefs)){
            $fail(trans('demotest::messages.duplicate_ref'));
        }
    }
}
