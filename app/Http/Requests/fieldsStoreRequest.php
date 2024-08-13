<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class fieldsStoreRequest extends FormRequest
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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'fields_type'=>'required|exists:fields_types,id'

        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'The Arabic month field is required.',
            'title_ar.string' => 'The Arabic month must be a string.',
            'title_ar.max' => 'The Arabic month may not be greater than 255 characters.',
            'title_en.required' => 'The English month field is required.',
            'title_en.string' => 'The English month must be a string.',
            'title_en.max' => 'The English month may not be greater than 255 characters.',
            'fields_type.required' => 'The fields type is required.',
            'fields_type.exists' => 'The selected fields type is invalid.'
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
