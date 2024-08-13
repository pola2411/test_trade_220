<?php

namespace App\Http\Requests;



use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddToWalitByAdminRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'balance' => 'required|numeric|min:0',
            'account_id'=>'required|exists:accounts,id'


        ];
    }


    public function messages()
    {
        return [
            'balance.required' => 'The balance field is required.',
            'balance.numeric' => 'The balance must be a number.',
            'balance.min' => 'The balance must be at least 0.',
            'account_id.required' => 'The account ID field is required.',
            'account_id.exists' => 'The selected account ID is invalid.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        // Display each error message with Toastr
        foreach ($errorMessages as $errorMessage) {
            Toastr::error($errorMessage, __('validation_custom.Error'));
        }

        parent::failedValidation($validator);
    }

}
