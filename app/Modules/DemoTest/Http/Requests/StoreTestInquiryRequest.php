<?php

namespace App\Modules\DemoTest\Http\Requests;

use App\Modules\DemoTest\Http\Requests\BaseFormRequest;
use App\Modules\DemoTest\Rules\DuplicateInactiveRefsRule;

class StoreTestInquiryRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payload' =>  ['required', 'array','max:2000', new DuplicateInactiveRefsRule],
            'payload.*.ref' => 'required|string',
            'payload.*.name' => 'required|string',
            'payload.*.description' => 'nullable|string'
        ];
    }
}
