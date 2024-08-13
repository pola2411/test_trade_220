<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class fieldsCountryStoreRequest extends FormRequest
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
            'country_id' => 'required|exists:countries,id',
            'field_id' => 'required|numeric|unique:fields_countries,field_id,NULL,id,country_id,' . $this->country_id,


        ];
    }

    public function messages()
    {
        return [
            'country_id.required' => 'The country field is required.',
            'country_id.exists' => 'The selected country is invalid.',
            'field_id.required' => 'The field ID is required.',
            'field_id.numeric' => 'The field ID must be a number.',
            'field_id.unique' => 'The field ID has already been taken for the selected country.'

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
