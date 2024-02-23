<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CaseRequest extends FormRequest
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
            'case_number'        => ['required'],
            'case_summary'        => ['nullable'],
            'current_status'      => ['nullable'],
            'client_id'    => ['nullable'],
            'date_of_warrant'      => ['nullable'],
            'collection_commission'    => ['nullable'],
            'field_visit'    => ['nullable'],
            // 'bal_field_visit'    => ['nullable'],
            'manager_ic'    => ['nullable'],
            'collector_ic'    => ['nullable'],
            'name'    => ['required'],
            'nric'    => ['nullable'],
            'company_name'    => ['nullable'],
            'company_uen'    => ['nullable'],
            'phone'    => ['nullable'],
            'email'    => ['nullable'],
            'adderss'    => ['nullable'],
            'debt_amount'    => ['nullable'],
            'legal_cost'    => ['nullable'],
            'debt_interest'    => ['nullable'],
            'interest_start_date'    => ['nullable'],
            'interest_end_date'    => ['nullable'],
            'total_interest'    => ['nullable'],
            'total_amount_owed'    => ['nullable'],
            'total_amount_balance'    => ['nullable'],
        ];


        return $rules;
    }
}
