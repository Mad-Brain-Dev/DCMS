<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CaseEditRequest extends FormRequest
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
            'amount_owed'      => ['required'],
            'case_type'        => ['required'],
            'case_status'      => ['required'],
            'case_priority'    => ['required'],
            'due_date'    => ['required'],
        ];


        return $rules;
    }

}
