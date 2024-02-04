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
            'current_status'      => ['required'],
            'client_id'    => ['required'],
            'date_of_agreement'        => ['required'],
            'date_of_expiry'      => ['required'],
            'collection_commission'    => ['required'],
            'field_visit'    => ['required'],
            'bal_field_visit'    => ['required'],
            'manager_ic'    => ['required'],
            'collector_ic'    => ['required'],
            'name'    => ['required'],
            'nric'    => ['nullable'],
            'company_name'    => ['nullable'],
            'company_uen'    => ['nullable'],
            'phone'    => ['required'],
            'email'    => ['required'],
            'adderss'    => ['required'],
            'debt_amount'    => ['required'],
            'legal_cost'    => ['required'],
            'debt_interest'    => ['required'],
            'interest_start_date'    => ['required'],
            'interest_end_date'    => ['required'],
            'total_interest'    => ['required'],
            'total_amount_owed'    => ['required'],
            'total_amount_paid'    => ['required'],
            'total_amount_balance'    => ['required'],
        ];


        return $rules;
    }
}
