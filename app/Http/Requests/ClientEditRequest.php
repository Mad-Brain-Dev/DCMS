<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClientEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $rules =  [
            'name' => ['required'],
            'abbr' => ['nullable'],
            'nric' => ['nullable'],
            'company_name' => ['nullable'],
            'company_uen' => ['nullable'],
            'phone'      => ['nullable'],
            'address' => ['nullable'],
            'account_name' => ['required'],
            'bank_name' => ['required'],
            'account_number' => ['required'],
            'bank_code' => ['required'],
            'branch_code' => ['required'],
            'bank_address' => ['required'],
            'swift_code' => ['required'],
            'payment_methods' => ['required'],
        ];
        return $rules;
    }

}
