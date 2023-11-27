<?php

namespace App\Modules\DemoTest\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestIsActiveStatusRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ref' => "required|string|exists:demo_test,ref,is_active,$this->status"
        ];
    }

    /**
     * Add parameters to be validated
     *
     * @return array
     */
    public function all($keys = null)
    {
        return array_replace_recursive(
            parent::all($keys),
            $this->route()->parameters()
        );
    }

    public function messages()
    {
        return [
            'ref.exists' => trans('demotest::messages.ref_not_exist', ['action' => $this->action])
        ];
    }
}
