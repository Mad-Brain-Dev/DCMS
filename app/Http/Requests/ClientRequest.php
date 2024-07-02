<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClientRequest extends FormRequest
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
            'abbr' => ['required|max:3'],
            'client_id' => ['nullable'],
            'nric' => ['nullable'],
            'company_name' => ['nullable'],
            'admin_fee' => ['nullable'],
            'company_uen' => ['nullable'],
            'email'      => ['nullable'],
            'phone'      => ['nullable'],
            'address' => ['nullable'],
            'date_of_agreement' => ['nullable'],
            'date_of_expiry' => ['nullable'],
            'collection_commission' => ['nullable'],
            'collected_by' => ['nullable'],
            'collection_date' => ['required'],
            'field_visit_per_case' => ['nullable'],
        ];
        return $rules;
    }

}
