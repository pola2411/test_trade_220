<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BankUpdateRequest extends FormRequest
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
            'feas'=>'required|numeric|min:0',
            'persage'=>'required|boolean',
            'id' => 'required|exists:banks,id'


        ];
    }


    public function messages()
    {
        return [
            'title_ar.required' => 'The title ar field is required.',
            'title_ar.string' => 'The title ar must be a string.',
            'title_ar.max' => 'The title ar may not be greater than 255 characters.',
            'title_en.required' => 'The title en field is required.',
            'title_en.string' => 'The title en must be a string.',
            'title_en.max' => 'The title en may not be greater than 255 characters.',

            'feas.required' => 'The feas field is required.',
            'feas.numeric' => 'The feas must be a numeric.',
            'feas.min' => 'The feas may not be less than 0 .',
            'persage.required'=>'The Feas Type field is required.',
            'persage.boolean'=>'The Feas Type field is boolean.',
            'id.required' => 'The ID field is required.',
            'id.exists' => 'The selected ID is invalid.',

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
